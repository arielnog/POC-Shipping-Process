<?php

namespace Tests\Unit\ValueObjects;

use App\Enum\FileStatusEnum;
use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\FileStatus;
use Tests\TestCase;

class FileStatusTest extends TestCase
{
    /**
     * @return void
     */
    public function testWithInstanceWithSuccess(): void
    {
        $result = new FileStatus(FileStatusEnum::PROCESSED);

        self::assertInstanceOf(FileStatus::class, $result);
    }

    /**
     * @return void
     */
    public function testWithGetStatusProcessedWithSuccess(): void
    {
        $expected = FileStatusEnum::PROCESSED;

        $result = FileStatus::ProcessedStatus();

        self::assertInstanceOf(
            FileStatus::class,
            $result
        );
        self::assertEquals(
            $expected,
            $result->asString()
        );
    }

    /**
     * @return void
     */
    public function testWithGetStatusUnprocessedWithSuccess(): void
    {
        $expected = FileStatusEnum::UNPROCESSED;

        $result = FileStatus::UnprocessedStatus();

        self::assertInstanceOf(
            FileStatus::class,
            $result
        );
        self::assertEquals(
            $expected,
            $result->asString()
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testWithInstanceFromStringReturnedSuccess(): void
    {
        $result = FileStatus::fromString('Processed');

        self::assertInstanceOf(
            FileStatus::class,
            $result
        );
    }

    public function testWithInstanceAndReturnException()
    {
        self::expectException(InvalidArgumentException::class);

        $result = new FileStatus('teste');
    }
}
