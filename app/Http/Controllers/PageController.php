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
     * Privacy policy — PDPA (Malaysia) compliant notice, bilingual.
     */
    public function privacy(): View
    {
        return view('privacy');
    }
}
