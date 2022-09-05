<?php

namespace App\Entities;

use App\ValueObjects\Uuid;

class Client
{
    public function __construct(
        private Uuid $uuid,
        private string $name,
        private ?int $id = null
    ) {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'uuid' => $this->uuid->toString(),
            'name' => $this->name,
        ];
    }
}
