<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function notice(): View|RedirectResponse
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route($this->homeRoute());
        }

        return view('auth.verify-otp');
    }

    public function verify(Request $request, OtpService $otp): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'digits:6'],
        ]);

        $user = Auth::user();

        if (! $otp->verify($user, $request->input('code'))) {
            return back()->withErrors(['code' => 'That code is invalid or has expired.']);
        }

        return redirect()->route($this->homeRoute())
            ->with('status', 'Your email has been verified. Welcome to ClinicCare!');
    }

    public function resend(Request $request, OtpService $otp): RedirectResponse
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route($this->homeRoute());
        }

        $code = $otp->generateAndSend($user);

        return back()
            ->with('status', 'A new verification code has been sent to your email.')
            ->with(app()->environment('local') ? ['dev_otp' => $code] : []);
    }

    private function homeRoute(): string
    {
        return Auth::user()->isStaff() ? 'admin.dashboard' : 'patient.dashboard';
    }
}
