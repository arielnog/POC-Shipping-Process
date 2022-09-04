<?php

namespace App\Exceptions;

use Throwable;

class ProcessFileException extends CustomException
{
    public function __construct(
        string $publicMessage = 'Erro ao processar o arquivo.',
        ?string $privateMessage = null,
        ?array $context = null,
        Throwable $previous = null
    ) {
        parent::__construct(
            $publicMessage,
            $privateMessage,
            400,
            0,
            $context,
            $previous
        );
    }
}
