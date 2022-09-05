<?php

namespace App\Repositories;

use App\Entities\Client;

interface ClientRepositoryInterface
{
    public function findById(int $id): ?Client;

    public function create(Client $client): ?Client;
}
