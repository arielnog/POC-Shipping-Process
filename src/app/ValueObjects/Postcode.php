<?php

namespace App\ValueObjects;

use App\Exceptions\InvalidArgumentException;

final class Postcode
{
    private const REGEX_VALIDATE = "/^[0-9]{2}.[0-9]{3}-[0-9]{3}$/i";

    /**
     * @param string $data
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $data
    ) {
        $this->validate();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function validate()
    {
        if (!preg_match(self::REGEX_VALIDATE, $this->data)) {
            throw new InvalidArgumentException(
                publicMessage: "Parâmetro invalido.",
                context: [
                    'postcode' => $this->data
                ]
            );
        }
    }

    /**
     * @param string $data
     * @return Postcode
     * @throws InvalidArgumentException
     */
    public static function fromString(string $data): Postcode
    {
        return new self($data);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function withoutMask(): string
    {
        return (string)str_replace(['-', '.'], '', $this->data);
    }

}
