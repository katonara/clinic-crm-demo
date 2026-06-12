<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request, OtpService $otp): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'whatsapp' => $validated['whatsapp'] ?? null,
            'role' => 'patient',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        $code = $otp->generateAndSend($user);

        return redirect()->route('verification.notice')
            ->with('status', 'We sent a 6-digit verification code to your email.')
            ->with($this->devCode($code));
    }

    /**
     * In local/dev (mail goes to the log), surface the code so the flow is testable.
     */
    private function devCode(string $code): array
    {
        return app()->environment('local') ? ['dev_otp' => $code] : [];
    }
}
