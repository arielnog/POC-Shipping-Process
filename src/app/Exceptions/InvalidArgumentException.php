<?php

namespace App\Exceptions;

use Throwable;

class InvalidArgumentException extends CustomException
{
    public function __construct(
        string $publicMessage,
        ?string $privateMessage = null,
        ?array $context = null,
        Throwable $previous = null
    ) {
        parent::__construct(
            $publicMessage,
            $privateMessage,
            404,
            0,
            $context,
            $previous
        );
    }
}
