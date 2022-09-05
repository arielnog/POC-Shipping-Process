<?php

namespace App\Helper;

use App\ValueObjects\Resource;
use Generator;

class CsvHelper
{
    /**
     * @param Resource $file
     * @return Generator
     */
    public static function fromFile(Resource $file): Generator
    {
        while (!feof($file->getContent())) {
            yield fgetcsv(
                $file->getContent(),
                separator: ';'
            );
        }
    }
}
