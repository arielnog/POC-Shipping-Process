<?php

namespace App\Entities;

use App\ValueObjects\Postcode;

class Shipping
{

    public function __construct(
        private Postcode $fromPostcode,
        private Postcode $toPostcode,
        private float $fromWeight,
        private float $toWeight,
        private float $cost,
        private int $fileControlId,
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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'from_postcode' => $this->fromPostcode->toString(),
            'to_postcode' => $this->toPostcode->toString(),
            'from_weight'=>$this->fromWeight,
            'to_weight' => $this->toWeight,
            'cost' => $this->cost,
            'file_control_id' => $this->fileControlId
        ];
    }

    /**
     * @return array
     */
    public function toSave(): array
    {
        return [
            'from_postcode' => $this->fromPostcode->withoutMask(),
            'to_postcode' => $this->toPostcode->withoutMask(),
            'from_weight'=>$this->fromWeight,
            'to_weight' => $this->toWeight,
            'cost' => $this->cost,
            'file_control_id' => $this->fileControlId
        ];
    }
}
