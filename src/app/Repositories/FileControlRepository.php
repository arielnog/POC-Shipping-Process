<?php

namespace App\Repositories;

use App\Entities\Collection\FileControlCollection;
use App\Entities\FileControl;
use App\Models\FileControl as FileControlModel;
use App\ValueObjects\FileStatus;
use Exception;

class FileControlRepository implements FileControlRepositoryInterface
{
    public function __construct(
        private FileControlModel $fileControl
    ) {
    }

    public function create(FileControl $fileControl): FileControlModel
    {
        return $this->fileControl
            ->create(
                $fileControl->toArray()
            );
    }

    /**
     * @throws Exception
     */
    public function getByStatusAndName(
        FileStatus $status,
        array $pathNames
    ): FileControlCollection {
        $file = $this->fileControl
            ->where('status', $status->asString())
            ->whereIn('path', $pathNames)
            ->get()
            ->toArray();

        return FileControlCollection::fromArray($file);
    }

    public function updateStatus(
        FileStatus $status,
        FileControl $fileControl
    ): bool {
        return $this->fileControl
            ->where('id', $fileControl->getId())
            ->update([
                'status' => $status->asString()
            ]);
    }
}
