<?php

namespace App\Repositories;

use App\Entities\Client;
use App\Exceptions\InvalidArgumentException;
use App\Factories\ClientFactory;
use App\Models\Client as ClientModel;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        private ClientModel $client
    ) {
    }

    public function findById(int $id): ?Client
    {
        $client = $this->client
            ->where('id',$id)
            ->get()
            ->first();

        if (empty($client)) {
            return null;
        }

        return ClientFactory::fromModel($client);
    }

    /**
     * @param Client $client
     * @return Client|null
     * @throws InvalidArgumentException
     */
    public function create(Client $client): ?Client
    {
        $model = $this->client
            ->create($client->toArray());

        return ClientFactory::fromModel($model);
    }
}
