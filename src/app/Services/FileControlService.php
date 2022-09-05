<?php

namespace App\Services;

use App\DataTransferObject\ProcessFileDTO;
use App\Entities\Collection\FileControlCollection;
use App\Entities\FileControl;
use App\Events\ProcessFile\ProcessFileEvent;
use App\Exceptions\ProcessFileException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\SaveFileException;
use App\ValueObjects\PathName;
use App\ValueObjects\Resource;
use App\ValueObjects\Uuid;
use App\ValueObjects\FileStatus;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\FileControlRepositoryInterface;
use App\Exceptions\InvalidArgumentException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class FileControlService
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private FileControlRepositoryInterface $fileControlRepository,
        private ShippingService $shippingService
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function saveFile(array $files, int $clientId): bool
    {
        try {
            $client = $this->clientRepository->findById($clientId);

            if (is_null($client)) {
                throw new ResourceNotFoundException(
                    publicMessage: 'Não foi encontrado o cliente informado.',
                    context: [
                        'client_id' => $clientId
                    ]
                );
            }

            $fileCollection = new FileControlCollection();

            foreach ($files as $file) {
                $pathName = new PathName(
                    [
                        $client->getUuid()->toString(),
                        time()
                    ]
                );

                $storage = $this->saveOnStorage($pathName, $file);

                if (!$storage) {
                    throw new InvalidArgumentException(
                        publicMessage: "Error ao salvar arquivo no storage local.",
                        context: [
                            'path_name' => $pathName
                        ]
                    );
                }

                $fileEntity = new FileControl(
                    uuid: Uuid::generate(),
                    fileName: $file->getClientOriginalName(),
                    pathName: $pathName->generateToCsv(),
                    status: FileStatus::UnprocessedStatus()
                );

                $fileEntity->setClientId($client->getId());

                $fileCollection->addFile($fileEntity);

                $this->fileControlRepository->create($fileEntity);
            }

            event(ProcessFileEvent::EVENT_NAME, $fileCollection);

            return true;
        } catch (Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @param PathName $fileName
     * @param UploadedFile $file
     * @return bool
     */
    private function saveOnStorage(PathName $fileName, UploadedFile $file): bool
    {
        return Storage::disk('local')
            ->put(
                $fileName->generateToCsv(),
                $file->getContent()
            );
    }

    /**
     * @param ProcessFileDTO $fileDTO
     * @return void
     * @throws ResourceNotFoundException
     * @throws Throwable
     */
    public function processFile(ProcessFileDTO $fileDTO)
    {
        try {
            $filesControl = $this->fileControlRepository
                ->getByStatusAndName(
                    FileStatus::UnprocessedStatus(),
                    $fileDTO->getPathNames()
                );

            if ($filesControl->isEmpty()) {
                throw new ResourceNotFoundException(
                    publicMessage: 'Não foram encontrados os arquivos informados.',
                    context: [
                        'path_name' => $fileDTO->getPathNames()
                    ]
                );
            }

            foreach ($filesControl->getItems() as $item) {
                $file = Storage::disk('local')->readStream($item->getPathName());

                $fileResource = new Resource($file);

                $shippingSave = $this->shippingService->createShippingFromParser($item, $fileResource);

                if ($shippingSave) {
                    $this->fileControlRepository->updateStatus(
                        FileStatus::ProcessedStatus(),
                        $item
                    );
                }
            }
        } catch (Throwable $exception) {
           throw $exception;
        }
    }
}
