<?php

namespace App\ValueObjects;

use App\Exceptions\InvalidArgumentException;

final class PathName
{
    protected string $pathName;

    protected const CSV_TYPE = '.csv';

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private array $data
    ) {
        $this->build();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function build()
    {
        if (empty($this->data)) {
            throw new InvalidArgumentException(
                publicMessage: "Parâmetro inválido"
            );
        }

        $this->pathName = implode(DIRECTORY_SEPARATOR, $this->data);
    }

    /**
     * @return string
     */
    public function generateToCsv(): string
    {
        return DIRECTORY_SEPARATOR . $this->pathName . self::CSV_TYPE;
    }


    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->pathName;
    }
}
