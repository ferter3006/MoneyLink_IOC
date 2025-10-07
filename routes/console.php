<?php

use App\Jobs\VerifyTokensExpiratedJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(VerifyTokensExpiratedJob::class)->everyFifteenMinutes(); // Cada 15 minutos
