<?php

namespace App\Factories;

use App\Entities\Client;
use App\Exceptions\InvalidArgumentException;
use App\Models\Client as ClientModel;
use App\ValueObjects\Uuid;
use App\Utils\Interact;

class ClientFactory
{
    use Interact;

    /**
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): Client
    {
        return new Client(
            uuid: isset($data['uuid']) ?
                new Uuid(self::getData($data, 'uuid')) :
                Uuid::generate(),
            name: self::getData($data, 'name'),
            id: self::getData($data, 'id')
        );
    }

    /**
     * @param ClientModel $client
     * @return Client
     * @throws InvalidArgumentException
     */
    public static function fromModel(ClientModel $client): Client
    {
        $data = $client->toArray();

        return self::fromArray($data);
    }
}
