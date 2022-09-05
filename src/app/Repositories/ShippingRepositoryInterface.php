<?php

namespace App\Repositories;

use App\Entities\Shipping;
use App\Models\Shipping as ShippingModel;

interface ShippingRepositoryInterface
{
    public function create(Shipping $shipping): ShippingModel;
}
