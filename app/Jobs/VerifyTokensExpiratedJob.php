<?php

namespace App\Jobs;

use App\Services\CacheTokenService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class VerifyTokensExpiratedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(CacheTokenService $tokenService): void
    {
        //$tokenService->borraTokensExpirados(); REdis ya lo hace por mi
    }
}
