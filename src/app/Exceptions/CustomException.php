<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Throwable;

class CustomException extends Exception implements JsonSerializable, Arrayable
{
    protected const HTTP_STATUS_CODE_ERROR_DEFAULT = 400;
    protected array $errors = [];
    protected array $privateErrors = [];
    protected array $context = [];

    public function __construct(
        string $publicMessage,
        protected ?string $privateMessage = null,
        protected int $httpStatusCode = self::HTTP_STATUS_CODE_ERROR_DEFAULT,
        int $errorCode = 0,
        array|null $context = null,
        Throwable $previous = null
    ) {
        parent::__construct($publicMessage, $errorCode, $previous);
        $this->privateMessage = is_null($privateMessage) ? $publicMessage : $privateMessage;
        $this->context = $context ?? [];
    }

    /**
     * @return string
     */
    public function getPublicMessage(): string
    {
        return $this->getMessage();
    }

    /**
     * @param string $message
     */
    public function setPrivateMessage(string $message): void
    {
        $this->privateMessage = $message;
    }

    /**
     * @param int $code
     */
    public function setErrorCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getPrivateMessage(): string
    {
        return  $this->privateMessage;
    }

    /**
     * @param string $default
     * @return string
     */
    public function getMessageOrDefault(
        string $default = 'Erro ao processar a sua solicitação.'
    ): string {
        return $this->hasMessage() ? $this->getMessage() : $default;
    }

    /**
     * @param string $default
     * @return string
     */
    public function getPublicMessageOrDefault(
        string $default = 'Erro ao processar a sua solicitação.'
    ): string {
        return $this->hasPublicMessage() ? $this->getPublicMessage() : $default;
    }

    /**
     * @param string $default
     * @return string
     */
    public function getPrivateMessageOrDefault(
        string $default = 'Erro ao processar a sua solicitação.'
    ): string {
        return $this->hasPrivateMessage() ? $this->getPrivateMessage() : $default;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @param array $context
     */
    public function setContext(array $context): void
    {
        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function getPrivateErrors(): array
    {
        return $this->privateErrors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasPrivateErrors(): bool
    {
        return !empty($this->getPrivateErrors());
    }


    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->getErrors());
    }

    /**
     * @return bool
     */
    public function hasContext(): bool
    {
        return !empty($this->getContext());
    }

    /**
     * @return bool
     */
    public function hasPrivateMessage(): bool
    {
        return !empty($this->getPrivateMessage());
    }

    /**
     * @return bool
     */
    public function hasHttpStatusCode(): bool
    {
        return !empty($this->getHttpStatusCode());
    }

    /**
     * @return bool
     */
    public function hasMessage(): bool
    {
        return !empty($this->getMessage());
    }

    /**
     * @return bool
     */
    public function hasPublicMessage(): bool
    {
        return $this->hasMessage();
    }

    /**
     * @param bool $privateContent
     * @return string
     */
    public function asString(bool $privateContent = false): string
    {
        if ($privateContent) {
            $formattedMessage = (empty($this->code) ? "" : " [$this->code]") .
                ": " . $this->getPrivateMessage();

            return get_called_class() . $formattedMessage;
        }

        return (empty($this->code) ? "" : "[$this->code]: ") . $this->getMessage();
    }

    /**
     * @return string
     */
    public function asPrivateString(): string
    {
        $formattedMessage = (empty($this->code) ? "" : " [$this->code]") .
            ": " . $this->getPrivateMessage();

        return get_called_class() . $formattedMessage;
    }


    /**
     * @param bool $detailed
     * @return array
     */
    public function jsonSerialize(bool $detailed = true): array
    {
        return $this->toArray($detailed);
    }

    /**
     * @param bool $detailed
     * @return array
     */
    public function jsonSerializePrivate(bool $detailed = true): array
    {
        return $this->toPrivateArray($detailed);
    }

    /**
     * @param bool $detailed
     * @return array
     */
    public function toArray(bool $detailed = true): array
    {
        $data = [
            'publicMessage' => $this->getMessageOrDefault(),
            'httpStatusCode' => $this->getHttpStatusCode(),
            'errorCode' => $this->getCode()
        ];

        if ($detailed && $this->hasErrors()) {
            $data['errors'] = $this->getErrors();
        }

        return $data;
    }

    /**
     * @param bool $detailed
     * @return array
     */
    public function toPrivateArray(bool $detailed = true): array
    {
        $data = [
            'publicMessage' => $this->getMessageOrDefault(),
            'privateMessage' => $this->getPrivateMessageOrDefault(),
            'httpStatusCode' => $this->getHttpStatusCode(),
            'errorCode' => $this->getCode()
        ];

        if ($detailed) {
            $data['exceptionClass'] = get_class($this);
            $data['context'] = $this->getContext();

            if ($this->hasErrors()) {
                $data['errors'] = $this->getErrors();
            }

            if ($this->hasPrivateErrors()) {
                $data['privateErrors'] = $this->getPrivateErrors();
            }
        }

        return $data;
    }
}
