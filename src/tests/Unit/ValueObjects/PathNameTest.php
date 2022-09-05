<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\PathName;
use Tests\TestCase;

class PathNameTest extends TestCase
{
    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testWithInstanceWithSuccess(): void
    {
        $expected = 'test' . DIRECTORY_SEPARATOR . 'teste' . DIRECTORY_SEPARATOR . 'file.pdf';

        $result = new PathName([
            'test',
            'teste',
            'file.pdf'
        ]);

        self::assertInstanceOf(PathName::class, $result);
        self::assertEquals($expected, $result->asString());
    }


    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testGeneratePathToCsvWithSuccess(): void
    {
        $expected = DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'teste' . DIRECTORY_SEPARATOR . 'file.csv';

        $result = new PathName([
            'test',
            'teste',
            'file'
        ]);

        self::assertEquals($expected, $result->generateToCsv());
    }

    public function testWithInstanceAndReturnException()
    {
        self::expectException(InvalidArgumentException::class);

        $result = new PathName([]);
    }
}
