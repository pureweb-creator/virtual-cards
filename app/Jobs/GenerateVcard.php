<?php

namespace App\Jobs;

use App\DTO\VCardDTO;
use App\Services\VCardService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateVcard implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int|null|string $userId
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(VCardService $VCardService): void
    {
        try{
            $VCardService->generate(new VCardDTO(userId: $this->userId));
        } catch (\Exception $e){
            \Log::error("Error processing job {$this->userId}: ".$e->getMessage());
        }
    }
}
