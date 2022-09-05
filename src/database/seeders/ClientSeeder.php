<?php

namespace Database\Seeders;

use App\Factories\ClientFactory;
use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientFactory = ClientFactory::fromArray([
            'name' => 'Teste'
        ]);

        Client::create($clientFactory->toArray());
    }
}
