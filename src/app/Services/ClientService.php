<?php

namespace App\Services;

use App\Entities\Client;
use App\Exceptions\ClientSaveException;
use App\Factories\ClientFactory;
use App\Repositories\ClientRepositoryInterface;
use App\Exceptions\InvalidArgumentException;
use Throwable;

class ClientService
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    /**
     * @param array $data
     * @return Client|null
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function save(array $data): ?Client
    {
        try {
            if (empty($data)){
                throw new InvalidArgumentException(
                    'Sem parametros'
                );
            }

            $client = ClientFactory::fromArray($data);

            return $this->clientRepository->create($client);
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}
