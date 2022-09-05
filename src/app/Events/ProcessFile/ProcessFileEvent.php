<?php

namespace App\Events\ProcessFile;

use App\DataTransferObject\ProcessFileDTO;
use App\Entities\Collection\FileControlCollection;
use App\Exceptions\InvalidArgumentException;
use App\Jobs\ProcessShippingFileJob;
use Exception;
use Illuminate\Queue\SerializesModels;

class ProcessFileEvent
{
    use SerializesModels;

    public const EVENT_NAME = 'PROCESS_FILE';

    /**
     * @throws InvalidArgumentException
     */
    public function handle(FileControlCollection $fileControlCollection): bool
    {
        try {
            $dto = ProcessFileDTO::fromArray([
                'path_name' => $fileControlCollection->getPathNames()
            ]);

            ProcessShippingFileJob::dispatch($dto);

            return true;
        } catch (Exception $exception) {
            throw new InvalidArgumentException(
              publicMessage: $exception->getMessage()
            );
        }
    }
}
