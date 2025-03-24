<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('bookings:send-qr-code-by-mail')->dailyAt('08:00');
Schedule::command('app:delete-qr-codes-storage')->dailyAt('00:00');


//Schedule::command('app:delete-qr-codes-storage')->everyMinute();
//Schedule::command('bookings:send-qr-code-by-mail')->everyMinute();

