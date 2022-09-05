<?php

namespace Tests\Unit\Repositories;

use App\Entities\Client as ClientEntity;
use App\Entities\Collection\FileControlCollection;
use App\Entities\FileControl as FileControlEntity;
use App\Exceptions\InvalidArgumentException;
use App\Factories\ClientFactory;
use App\Factories\FileControlFactory;
use App\Models\Client;
use App\Models\FileControl;
use App\Repositories\ClientRepository;
use App\Repositories\FileControlRepository;
use App\ValueObjects\FileStatus;
use App\ValueObjects\Uuid;
use Mockery;
use Tests\TestCase;

class FileControlRepositoryTest extends TestCase
{
    protected FileControl $fileControlMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->fileControlMock = Mockery::mock(FileControl::class);
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function testGetFileByStatusUnprocessedWithSuccess(): void
    {
        $arr = [
            [
                'uuid' => Uuid::generate()->toString(),
                'file_name' => 'teste.csv',
                'path' => 'teste/teste/file.csv',
                'status' => 'Unprocessed',
            ]
        ];

        $pathNames = [
            'teste/teste/file.csv'
        ];

        $this->fileControlMock
            ->shouldReceive('where')
            ->once()
            ->withArgs([
                'status',
                FileStatus::UnprocessedStatus()->asString()
            ])
            ->andReturnSelf();

        $this->fileControlMock
            ->shouldReceive('whereIn')
            ->once()
            ->withArgs([
                'path',
                $pathNames
            ])
            ->andReturnSelf();

        $this->fileControlMock
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf();

        $this->fileControlMock
            ->shouldReceive('toArray')
            ->once()
            ->andReturn($arr);

        $response = new FileControlRepository($this->fileControlMock);
        $result = $response->getByStatusAndName(FileStatus::UnprocessedStatus(), $pathNames);

        self::assertInstanceOf(FileControlCollection::class, $result);
    }

    /**
     * @throws \App\Exceptions\InvalidArgumentException
     */
    public function testCreateFileWithSuccess(): void
    {
        $arr = [
            'uuid' => Uuid::generate()->toString(),
            'file_name' => 'teste.csv',
            'path' => 'teste/teste/file.csv',
            'status' => 'Unprocessed',
        ];

        $fileControl = FileControlFactory::fromArray($arr);
        $fileControl->setClientId(1);

        $this->fileControlMock
            ->shouldReceive('create')
            ->withArgs([
                $fileControl->toArray()
            ])
            ->andReturn(new FileControl($arr));

        $response = new FileControlRepository($this->fileControlMock);
        $result = $response->create($fileControl);

        self::assertInstanceOf(FileControl::class, $result);
    }


    public function testUpdateFileStatusWithSuccess(): void
    {
        $arr = [
            'uuid' => Uuid::generate()->toString(),
            'file_name' => 'teste.csv',
            'path' => 'teste/teste/file.csv',
            'status' => 'Unprocessed',
        ];

        $fileControl = FileControlFactory::fromArray($arr);
        $fileControl->setClientId(1);

        $status = FileStatus::ProcessedStatus();

        $this->fileControlMock
            ->shouldReceive('where')
            ->once()
            ->withArgs([
                'id',
                $fileControl->getId()
            ])
            ->andReturnSelf();

        $this->fileControlMock
            ->shouldReceive('update')
            ->once()
            ->andReturnTrue();

        $response = new FileControlRepository($this->fileControlMock);
        $result = $response->updateStatus(
            $status,
            $fileControl
        );

        self::assertTrue( $result);
    }
}
