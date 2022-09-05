<?php

namespace App\Repositories;

use App\Entities\Collection\FileControlCollection;
use App\Entities\FileControl;
use App\ValueObjects\FileStatus;

interface FileControlRepositoryInterface
{
    public function create(FileControl $fileControl);

    public function getByStatusAndName(FileStatus $status, array $pathNames): FileControlCollection;

    public function updateStatus(FileStatus $status, FileControl $fileControl): bool;
}
