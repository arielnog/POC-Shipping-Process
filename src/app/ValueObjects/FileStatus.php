<?php

namespace App\ValueObjects;

use App\Enum\FileStatusEnum;
use App\Exceptions\InvalidArgumentException;
use Exception;

final class FileStatus
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $status
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (!in_array($this->status, FileStatusEnum::validValues())) {
            throw new InvalidArgumentException(
                publicMessage: "Status invalido.",
                context: [
                    'status' => $this->status
                ]
            );
        }
    }

    /**
     * @return FileStatus
     */
    public static function UnprocessedStatus(): FileStatus
    {
        return new self(FileStatusEnum::UNPROCESSED);
    }

    /**
     * @return FileStatus
     */
    public static function ProcessedStatus(): FileStatus
    {
        return new self(FileStatusEnum::PROCESSED);
    }

    /**
     * @throws InvalidArgumentException|\Exception
     */
    public static function fromString(string $data): FileStatus
    {
        return new self($data);
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->status;
    }
}
