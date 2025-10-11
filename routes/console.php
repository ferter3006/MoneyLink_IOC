<?php

use App\Jobs\VerifyTiquetsRecurrentes;
use App\Jobs\VerifyTokensExpiratedJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(VerifyTiquetsRecurrentes::class)->everyFifteenSeconds (); // Cada 15 segundos

