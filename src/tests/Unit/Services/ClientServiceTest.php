<?php

namespace Tests\Unit\Service;

use App\Entities\Client;
use App\Exceptions\InvalidArgumentException;
use App\Factories\ClientFactory;
use App\Repositories\ClientRepositoryInterface;
use App\Services\ClientService;
use App\ValueObjects\Uuid;
use Mockery;
use Tests\TestCase;

class ClientServiceTest extends TestCase
{
    protected ClientRepositoryInterface $clientRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepositoryMock = Mockery::mock(ClientRepositoryInterface::class);
    }

    /**
     * @throws \App\Exceptions\ClientSaveException
     * @throws \App\Exceptions\InvalidArgumentException
     */
    public function testCreateClientWithSuccess()
    {
        $arr = [
            'name' => 'teste',
            'uuid' => Uuid::generate()->toString()
        ];

        $client = ClientFactory::fromArray($arr);

        $this->clientRepositoryMock
            ->shouldReceive('save')
            ->andReturn($client);

        $response = new ClientService(
            $this->clientRepositoryMock
        );

       $result = $response->save($arr);

        self::assertInstanceOf(Client::class,$result);
        self::assertEquals($arr,$result->toArray());
    }

    public function testCreateClientWithEmptyParams(): void
    {
        self::expectException(InvalidArgumentException::class);

        $this->clientRepositoryMock
            ->shouldReceive('save')
            ->andReturnNull();

        $response = new ClientService(
            $this->clientRepositoryMock
        );

       $response->save([]);
    }
}
