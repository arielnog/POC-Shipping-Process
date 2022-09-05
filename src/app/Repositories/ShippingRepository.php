<?php

namespace App\Repositories;

use App\Entities\Shipping;
use App\Exceptions\InvalidArgumentException;
use App\Factories\ShippingFactory;
use App\Models\Shipping as ShippingModel;

class ShippingRepository implements ShippingRepositoryInterface
{
    public function __construct(
        private ShippingModel $shipping
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(Shipping $shipping): ShippingModel
    {
        return $this->shipping
            ->create(
                $shipping->toSave()
            );

    }
}
