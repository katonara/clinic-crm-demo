<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request, OtpService $otp): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Unverified patients must complete OTP verification first.
        if (! $user->hasVerifiedEmail()) {
            $code = $otp->generateAndSend($user);

            return redirect()->route('verification.notice')
                ->with('status', 'Please verify your email. A new code has been sent.')
                ->with(app()->environment('local') ? ['dev_otp' => $code] : []);
        }

        return redirect()->intended($this->homeFor());
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function homeFor(): string
    {
        return Auth::user()->isStaff()
            ? route('admin.dashboard')
            : route('patient.dashboard');
    }
}
