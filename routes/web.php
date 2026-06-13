<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Patient;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');

/*
|--------------------------------------------------------------------------
| Guest authentication (register, login, OTP, password reset)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

// Email OTP verification (auth but not-yet-verified).
Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [OtpVerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/verify-email', [OtpVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verify-email/resend', [OtpVerificationController::class, 'resend'])->name('verification.resend');
});

/*
|--------------------------------------------------------------------------
| Patient area (auth + verified)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [Patient\DashboardController::class, 'index'])->name('patient.dashboard');

    Route::get('/book-appointment', [Patient\AppointmentController::class, 'create'])->name('book');
    Route::post('/book-appointment', [Patient\AppointmentController::class, 'store'])->name('patient.appointments.store');
    Route::get('/book-appointment/availability', [Patient\AppointmentController::class, 'availability'])->name('patient.appointments.availability');
    Route::get('/appointments/{appointment}/reschedule', [Patient\AppointmentController::class, 'edit'])->name('patient.appointments.edit');
    Route::patch('/appointments/{appointment}', [Patient\AppointmentController::class, 'update'])->name('patient.appointments.update');
    Route::patch('/appointments/{appointment}/cancel', [Patient\AppointmentController::class, 'cancel'])->name('patient.appointments.cancel');

    Route::get('/profile', [Patient\ProfileController::class, 'edit'])->name('patient.profile');
    Route::patch('/profile', [Patient\ProfileController::class, 'update'])->name('patient.profile.update');
    Route::patch('/profile/password', [Patient\ProfileController::class, 'updatePassword'])->name('patient.profile.password');
});

/*
|--------------------------------------------------------------------------
| Staff / admin area (auth + verified + staff)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/appointments', [Admin\AppointmentController::class, 'index'])->name('appointments');
    Route::get('/appointments/export', [Admin\AppointmentController::class, 'export'])->name('appointments.export');
    Route::get('/appointments/{appointment}/reschedule', [Admin\AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::patch('/appointments/{appointment}', [Admin\AppointmentController::class, 'update'])->name('appointments.update');
    Route::patch('/appointments/{appointment}/status', [Admin\AppointmentController::class, 'updateStatus'])->name('appointments.status');

    Route::get('/calendar', [Admin\CalendarController::class, 'index'])->name('calendar');
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports');

    Route::get('/patients', [Admin\PatientController::class, 'index'])->name('patients');
    Route::get('/patients/{patient}', [Admin\PatientController::class, 'show'])->name('patients.show');

    Route::get('/services', [Admin\ServiceController::class, 'index'])->name('services');
    Route::post('/services', [Admin\ServiceController::class, 'store'])->name('services.store');
    Route::patch('/services/{service}/toggle', [Admin\ServiceController::class, 'toggle'])->name('services.toggle');

    Route::get('/rooms', [Admin\RoomController::class, 'index'])->name('rooms');
    Route::post('/rooms', [Admin\RoomController::class, 'store'])->name('rooms.store');
    Route::patch('/rooms/{room}/toggle', [Admin\RoomController::class, 'toggle'])->name('rooms.toggle');
});
