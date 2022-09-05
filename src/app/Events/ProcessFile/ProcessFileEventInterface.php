<?php

namespace App\Events\ProcessFile;

use App\Entities\Collection\FileControlCollection;

interface ProcessFileEventInterface
{
    public const EVENT_NAME = 'PROCESS_FILE';

    public function handle(FileControlCollection $fileControlCollection): bool;
}
