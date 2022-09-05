<?php

namespace Tests\Unit\Services;

use App\DataTransferObject\ProcessFileDTO;
use App\Entities\Collection\FileControlCollection;
use App\Events\ProcessFile\ProcessFileEvent;
use App\Events\ProcessFile\ProcessFileEventInterface;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\ResourceNotFoundException;
use App\Factories\ClientFactory;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\FileControlRepositoryInterface;
use App\Services\FileControlService;
use App\Services\ShippingService;
use App\ValueObjects\Uuid;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;
use Throwable;

class FileControlServiceTest extends TestCase
{
    protected ClientRepositoryInterface $clientRepositoryMock;
    protected FileControlRepositoryInterface $fileControlRepositoryMock;
    protected ShippingService $shippingServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepositoryMock = Mockery::mock(ClientRepositoryInterface::class);
        $this->fileControlRepositoryMock = Mockery::mock(FileControlRepositoryInterface::class);
        $this->shippingServiceMock = Mockery::mock(ShippingService::class);
    }

    /**
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function testSaveFileWithSuccess()
    {
        $arrFiles = [];
        $clientId = 1;

        $clientEntity = ClientFactory::fromArray([
            'id' => 1,
            'uuid' => Uuid::generate()->toString(),
            'name' => 'Teste'
        ]);

        Event::fake([
            ProcessFileEventInterface::EVENT_NAME
        ]);

        $this->clientRepositoryMock
            ->shouldReceive('findById')
            ->withArgs([$clientId])
            ->andReturn($clientEntity);

        $this->fileControlRepositoryMock
            ->shouldReceive('create')
            ->andReturnNull();

        $response = new FileControlService(
            $this->clientRepositoryMock,
            $this->fileControlRepositoryMock,
            $this->shippingServiceMock
        );

        $result = $response->saveFile($arrFiles, $clientId);

        self::assertTrue($result);
        Event::assertListening(
            ProcessFileEventInterface::EVENT_NAME,
            ProcessFileEvent::class
        );
    }


    /**
     * @throws Throwable
     * @throws InvalidArgumentException
     */
    public function testSaveFileAndNotFoundClient()
    {
        self::expectException(ResourceNotFoundException::class);

        $clientId = 555;
        $arrFiles = [];

        $this->clientRepositoryMock
            ->shouldReceive('findById')
            ->andReturnNull();

        $response = new FileControlService(
            $this->clientRepositoryMock,
            $this->fileControlRepositoryMock,
            $this->shippingServiceMock
        );

        $response->saveFile($arrFiles, $clientId);
    }


    /**
     * @return void
     * @throws ResourceNotFoundException
     * @throws Throwable
     */
    public function testProcessFileWithGiveExceptionWithFileNotFound(): void
    {
        self::expectException(ResourceNotFoundException::class);
                $dto = ProcessFileDTO::fromArray([
            'path_name' => [
                '/teste/teste.csv'
            ]
        ]);

        $fileControlCollection = FileControlCollection::fromArray([]);

        $this->fileControlRepositoryMock
            ->shouldReceive('getByStatusAndName')
            ->andReturn($fileControlCollection);

        $response = new FileControlService(
            $this->clientRepositoryMock,
            $this->fileControlRepositoryMock,
            $this->shippingServiceMock
        );

        $response->processFile($dto);
    }
}
