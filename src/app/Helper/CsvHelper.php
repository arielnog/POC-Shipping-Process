<?php

namespace App\Helper;

use App\ValueObjects\Resource;
use Generator;

class CsvHelper
{
    /**
     * @param mixed $file
     * @return Generator
     */
    public static function fromFile(mixed $file): Generator
    {
        while (!feof($file)) {
            yield fgetcsv(
                $file,
                separator: ';'
            );
        }
    }
}
