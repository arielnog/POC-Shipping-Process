<?php

namespace Tests\Unit\Services;

use App\Entities\Client;
use App\Exceptions\ClientSaveException;
use App\Exceptions\InvalidArgumentException;
use App\Factories\ClientFactory;
use App\Repositories\ClientRepositoryInterface;
use App\Services\ClientService;
use App\ValueObjects\Uuid;
use Mockery;
use Tests\TestCase;
use Throwable;

class ClientServiceTest extends TestCase
{
    protected ClientRepositoryInterface $clientRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepositoryMock = Mockery::mock(ClientRepositoryInterface::class);
    }

    /**
     * @throws ClientSaveException
     * @throws InvalidArgumentException|Throwable
     */
    public function testCreateClientWithSuccess()
    {
        $arr = [
            'name' => 'teste',
            'uuid' => Uuid::generate()->toString(),
            'id' => null
        ];

        $client = ClientFactory::fromArray($arr);

        $this->clientRepositoryMock
            ->shouldReceive('create')
            ->andReturn($client);

        $response = new ClientService(
            $this->clientRepositoryMock
        );

       $result = $response->save($arr);

        self::assertInstanceOf(Client::class,$result);
        self::assertEquals($arr,$result->toArray());
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function testCreateClientWithEmptyParams(): void
    {
        self::expectException(InvalidArgumentException::class);

        $this->clientRepositoryMock
            ->shouldReceive('create')
            ->andReturnNull();

        $response = new ClientService(
            $this->clientRepositoryMock
        );

       $response->save([]);
    }
}
