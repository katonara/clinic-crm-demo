<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily follow-up reminders for tomorrow's confirmed appointments.
// Requires `php artisan schedule:work` (dev) or a cron running `schedule:run` (prod).
Schedule::command('appointments:reminders')->dailyAt('08:00');
