<?php

namespace Tests\Unit\Repositories;

use App\Entities\Client as ClientEntity;
use App\Entities\Shipping as ShippingEntity;
use App\Exceptions\InvalidArgumentException;
use App\Factories\ClientFactory;
use App\Factories\ShippingFactory;
use App\Models\Client;
use App\Models\Shipping;
use App\Repositories\ClientRepository;
use App\Repositories\ShippingRepository;
use App\ValueObjects\Uuid;
use Mockery;
use Tests\TestCase;

class ShippingRepositoryTest extends TestCase
{
    protected Shipping $shippingModelMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->shippingModelMock = Mockery::mock(Shipping::class);
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testCreateShippingRegisterWithSuccess(): void
    {
        $expected = [
            'from_postcode' => '21.770-010',
            'to_postcode' => '21.770-150',
            'from_weight' => '30,01',
            'to_weight' => '9.999,00',
            'cost' => '36,26',
            'file_control_id' => 1
        ];

        $shipping = ShippingFactory::fromArray($expected);

        $this->shippingModelMock
            ->shouldReceive('create')
            ->withArgs([
                $shipping->toSave()
            ])
            ->andReturn(new Shipping($expected));

        $response = new ShippingRepository($this->shippingModelMock);
        $result = $response->create($shipping);

        self::assertInstanceOf(Shipping::class, $result);
    }
}
