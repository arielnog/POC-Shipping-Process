<?php

namespace App\DataTransferObject;

use App\Utils\Interact;

final class ProcessFileDTO
{
    use Interact;

    /**
     * @param array $pathNames
     */
    public function __construct(
        private array $pathNames
    ) {
    }

    /**
     * @param array $data
     * @return ProcessFileDTO
     */
    public static function fromArray(array $data): ProcessFileDTO
    {
        return new self(
            pathNames: self::getData($data,'pathName','path_name')
        );
    }

    /**
     * @return array
     */
    public function getPathNames(): array
    {
        return $this->pathNames;
    }
}
