<?php

namespace App\Jobs;

use App\DataTransferObject\ProcessFileDTO;
use App\Services\FileControlService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessShippingFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private ProcessFileDTO $fileDTO)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileControlService = app(FileControlService::class);
        $fileControlService->processFile($this->fileDTO);
    }
}
