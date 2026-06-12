<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Public landing page.
     */
    public function home(): View
    {
        return view('home');
    }

    /**
     * Placeholder — patient login (Phase 2: authentication).
     */
    public function login(): View
    {
        return view('placeholder', [
            'title' => 'Login',
            'message' => 'Patient login will be available in the next phase.',
        ]);
    }

    /**
     * Placeholder — patient registration (Phase 2: registration + email OTP).
     */
    public function register(): View
    {
        return view('placeholder', [
            'title' => 'Create Account',
            'message' => 'Account registration with email OTP verification is coming soon.',
        ]);
    }

    /**
     * Placeholder — book an appointment (Phase 3: booking module).
     */
    public function book(): View
    {
        return view('placeholder', [
            'title' => 'Book Appointment',
            'message' => 'Online appointment booking is coming soon. Please register an account to get started.',
        ]);
    }

    /**
     * Privacy policy — PDPA (Malaysia) compliant notice, bilingual.
     */
    public function privacy(): View
    {
        return view('privacy');
    }
}
