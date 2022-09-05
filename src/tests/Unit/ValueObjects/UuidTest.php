<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\Uuid;
use Tests\TestCase;

class UuidTest extends TestCase
{
    /**
     * @return void
     */
    public function testWithInstanceWithSuccess(): void
    {
        $expected  = '1ef923a8-3c74-4966-ae80-c943a48b509f';

        $result = new Uuid('1ef923a8-3c74-4966-ae80-c943a48b509f');

        self::assertInstanceOf(Uuid::class, $result);
        self::assertEquals(
            $expected,
            $result->toString()
        );
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testWithGenerateWithSuccess(): void
    {
        $result = Uuid::generate();

        self::assertInstanceOf(
            Uuid::class,
            $result
        );
        self::assertIsString(
            $result->toString()
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testWithInstanceFromStringReturnedSuccess(): void
    {
        $result = Uuid::fromString('1ef923a8-3c74-4966-ae80-c943a48b509f');

        self::assertInstanceOf(
            Uuid::class,
            $result
        );
    }

    /**
     * @return void
     */
    public function testWithInstanceAndReturnException(): void
    {
        self::expectException(InvalidArgumentException::class);

        $result = new Uuid('teste');
    }
}
