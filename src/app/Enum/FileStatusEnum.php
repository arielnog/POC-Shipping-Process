<?php

namespace App\Enum;

class FileStatusEnum
{
    const UNPROCESSED = 'Unprocessed';
    const PROCESSED = 'Processed';

    /**
     * @var array|string[]
     */
    protected array $_all = [
        self::UNPROCESSED,
        self::PROCESSED,
    ];

    /**
     * @return string[]
     */
    public static function validValues(): array
    {
        return [
            self::UNPROCESSED,
            self::PROCESSED
        ];
    }
}
