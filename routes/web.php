<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Phase 1 — public landing page only. The auth/booking CTAs point at named
| placeholder routes so later phases (login, register, email OTP, booking)
| can replace the stub responses without touching the views.
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');

// Placeholder routes — replaced with real flows in later phases.
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/book-appointment', [PageController::class, 'book'])->name('book');

// Legal — PDPA (Malaysia) privacy notice.
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
