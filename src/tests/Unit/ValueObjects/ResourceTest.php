<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\Resource;
use Exception;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testWithInstanceWithSuccess(): void
    {
        $file = fopen(base_path('tests/Mock/teste.csv'), 'r');
        $result = new Resource($file);

        self::assertInstanceOf(Resource::class, $result);
    }

    /**
     * @throws Exception
     */
    public function testWithInstanceWithGetContent(): void
    {
        $file = fopen(base_path('tests/Mock/teste.csv'), 'r');
        $result = new Resource($file);

        self::assertIsResource($result->getContent());
    }

    public function testWithInstanceAndReturnException()
    {
        self::expectException(InvalidArgumentException::class);

        $result = new Resource('teste');
    }
}
