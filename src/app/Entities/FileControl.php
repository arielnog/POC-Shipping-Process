<?php

namespace App\Entities;

use App\ValueObjects\FileStatus;
use App\ValueObjects\Uuid;

class FileControl
{
    private ?int $clientId;

    public function __construct(
        private Uuid $uuid,
        private string $fileName,
        private string $pathName,
        private FileStatus $status,
        private ?int $id = null
    ) {
    }

    /**
     * @param int $clientId
     */
    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getPathName(): string
    {
        return $this->pathName;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'uuid' => $this->uuid->toString(),
            'file_name' => $this->fileName,
            'path' => $this->pathName,
            'status' => $this->status->asString(),
            'client_id' => $this->getClientId()
        ];
    }
}
