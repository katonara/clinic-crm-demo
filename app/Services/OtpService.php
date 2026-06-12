<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    /**
     * Minutes an OTP code stays valid.
     */
    public const TTL_MINUTES = 10;

    /**
     * Generate a fresh 6-digit OTP for the user, persist it, and email it.
     * Returns the plain code (handy for showing in local/dev environments).
     */
    public function generateAndSend(User $user): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'email_otp' => $code,
            'email_otp_expires_at' => now()->addMinutes(self::TTL_MINUTES),
        ])->save();

        Mail::to($user->email)->send(new OtpMail($user, $code));

        return $code;
    }

    /**
     * Verify a submitted code. On success, marks the email verified and clears the OTP.
     */
    public function verify(User $user, string $code): bool
    {
        if (empty($user->email_otp) || empty($user->email_otp_expires_at)) {
            return false;
        }

        if ($user->email_otp_expires_at->isPast()) {
            return false;
        }

        if (! hash_equals($user->email_otp, trim($code))) {
            return false;
        }

        $user->forceFill([
            'email_otp' => null,
            'email_otp_expires_at' => null,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();

        return true;
    }
}
