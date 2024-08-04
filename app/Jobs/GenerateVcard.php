<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateVcard implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly User $user
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(ProfileService $profileService): void
    {
        $profileService->generateVcard($this->user);
    }
}
