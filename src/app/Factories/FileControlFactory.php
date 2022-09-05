<?php

namespace App\Factories;

use App\Entities\FileControl;
use App\Exceptions\InvalidArgumentException;
use App\Models\FileControl as FileControlModel;
use App\ValueObjects\FileStatus;
use App\ValueObjects\Uuid;
use App\Utils\Interact;

class FileControlFactory
{
    use Interact;

    /**
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data)
    {
        return new FileControl(
            uuid: isset($data['uuid']) ?
                new Uuid(self::getData($data, 'uuid')) :
                Uuid::generate(),
            fileName: self::getData($data, 'file_name', 'fileName'),
            pathName: self::getData($data, 'path_name', 'pathName', 'path'),
            status: FileStatus::fromString(self::getData($data, 'status')),
            id: self::getData($data, 'id')
        );
    }

    public static function fromModel(FileControlModel $fileControl)
    {
        $data = $fileControl->toArray();

        return self::fromArray($data);
    }
}
