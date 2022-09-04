<?php

namespace App\Exceptions;

use Throwable;

class SaveFileException extends CustomException
{
    public function __construct(
        string $publicMessage = 'Erro ao salvar o(s) arquivo(s).',
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
