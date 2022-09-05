<?php

namespace App\Repositories;

use App\Entities\Shipping;

interface ShippingRepositoryInterface
{
    public function create(Shipping $shipping);
}
