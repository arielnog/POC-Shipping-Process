<?php

namespace Tests\Unit\Repositories;

use App\Entities\Client as ClientEntity;
use App\Exceptions\InvalidArgumentException;
use App\Factories\ClientFactory;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\ValueObjects\Uuid;
use Mockery;
use Tests\TestCase;

class ClientRepositoryTest extends TestCase
{
    protected Client $clientModelMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->clientModelMock = Mockery::mock(Client::class);
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testFindClientWithSuccess():void
    {
        $clientId = 1;

        $client = new Client([
            'id' => 1,
            'uuid' => Uuid::generate()->toString(),
            'name' => 'teste'
        ]);

        $this->clientModelMock
            ->shouldReceive('where')
            ->once()
            ->withArgs(['id', $clientId])
            ->andReturnSelf();

        $this->clientModelMock
            ->shouldReceive('get')
            ->andReturnSelf();

        $this->clientModelMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($client);

        $response = new ClientRepository($this->clientModelMock);
        $result = $response->findById($clientId);

        self::assertInstanceOf(ClientEntity::class, $result);
    }

    /**
     * @return void
     */
    public function testNotFindClient(): void
    {


        $this->clientModelMock
            ->shouldReceive('where')
            ->once()
            ->withArgs(['id', 4])
            ->andReturnSelf();

        $this->clientModelMock
            ->shouldReceive('get')
            ->andReturnSelf();

        $this->clientModelMock
            ->shouldReceive('first')
            ->once()
            ->andReturnNull();

        $response = new ClientRepository($this->clientModelMock);
        $result = $response->findById(4);

        self::assertNull($result);
    }

    /**
     * @throws \App\Exceptions\InvalidArgumentException
     */
    public function testSaveClientWithSuccess(): void
    {
        $arr = [
            'uuid' => Uuid::generate()->toString(),
            'name' => 'teste'
        ];

        $client = ClientFactory::fromArray($arr);

        $this->clientModelMock
            ->shouldReceive('create')
            ->withArgs([
                $client->toArray()
            ])
            ->andReturn(new Client($arr));

        $response = new ClientRepository($this->clientModelMock);
        $result = $response->create($client);

        self::assertInstanceOf(ClientEntity::class, $result);
    }
}
