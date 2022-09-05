<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\Postcode;
use Tests\TestCase;

class PostcodeTest extends TestCase
{
    /**
     * @return void
     */
    public function testWithInstanceWithSuccess(): void
    {
        $result = new Postcode('21.810-052');

        self::assertInstanceOf(Postcode::class, $result);
        self::assertEquals(
            '21.810-052',
            $result->toString()
        );
    }

    public function testWithInstanceWithSuccessAndReturnWithoutMask(): void
    {
        $result = new Postcode('21.810-052');

        self::assertInstanceOf(Postcode::class, $result);
        self::assertEquals(
            '21810052',
            $result->withoutMask()
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testWithInstanceFromStringReturnedSuccess(): void
    {
        $result = Postcode::fromString('21.810-052');

        self::assertInstanceOf(
            Postcode::class,
            $result
        );
    }

    public function testWithInstanceAndReturnException()
    {
        self::expectException(InvalidArgumentException::class);

        $result = new Postcode('21.810-0523');
    }
}
