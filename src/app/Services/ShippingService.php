<?php

namespace App\Services;
use App\Entities\FileControl;
use App\Factories\ShippingFactory;
use App\Helper\CsvHelper;
use App\ValueObjects\Resource;
use App\Exceptions\InvalidArgumentException;
use App\Repositories\ShippingRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class ShippingService
{
    public function __construct(
        private ShippingRepositoryInterface $shippingRepository
    ) {
    }

    /**
     * @param FileControl $fileControl
     * @param Resource $file
     * @return bool
     * @throws InvalidArgumentException
     */
    public function createShippingFromParser(FileControl $fileControl, Resource $file): bool
    {
        try {
            $csvRows = CsvHelper::fromFile($file->getContent());
            $keys = [];

            DB::beginTransaction();
            foreach ($csvRows as $row) {
                if (empty($keys)) {
                    $keys = $row;
                    continue;
                }

                if (!is_array($row) && empty($row)) {
                    continue;
                }

                $data = array_combine($keys, $row);
                $data['file_control_id'] = $fileControl->getId();

                $shipping = ShippingFactory::fromArray($data);

                $this->shippingRepository->create($shipping);
            }
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new InvalidArgumentException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}

