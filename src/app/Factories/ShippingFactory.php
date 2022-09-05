<?php

namespace App\Factories;

use App\Entities\Shipping;
use App\Exceptions\InvalidArgumentException;
use App\Models\Shipping as ShippingModel;
use App\ValueObjects\Postcode;
use App\Utils\Interact;

class ShippingFactory
{
    use Interact;

    /**
     * @param array $data
     * @return Shipping
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): Shipping
    {
        return new Shipping(
            fromPostcode: Postcode::fromString(
                self::getData($data, 'from_postcode', 'fromPostcode')
            ),
            toPostcode: Postcode::fromString(
                self::getData($data, 'to_postcode', 'toPostcode')
            ),
            fromWeight: floatval(
                str_replace(
                    ',',
                    '.',
                    str_replace(
                        '.',
                        '',
                        self::getData($data, 'from_weight', 'fromWeight'),
                    )
                )
            ),
            toWeight: floatval(
                str_replace(
                    ',',
                    '.',
                    str_replace(
                        '.',
                        '',
                        self::getData($data, 'to_weight', 'toWeight')
                    )
                )
            ),
            cost: floatval(
                str_replace(
                    ',',
                    '.',
                    str_replace(
                        '.',
                        '',
                        self::getData($data, 'cost'),

                    )
                )
            ),
            fileControlId: self::getData($data, 'file_control_id', 'fileControlId'),
            id: self::getData($data, 'id')
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromModel(ShippingModel $shipping): Shipping
    {
        $data = $shipping->toArray();

        return self::fromArray($data);
    }
}
