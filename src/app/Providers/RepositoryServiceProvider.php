<?php

namespace App\Providers;

use App\Repositories\ClientRepository;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\FileControlRepository;
use App\Repositories\FileControlRepositoryInterface;
use App\Repositories\ShippingRepository;
use App\Repositories\ShippingRepositoryInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ClientRepositoryInterface::class,
            ClientRepository::class
        );

        $this->app->bind(
            FileControlRepositoryInterface::class,
            FileControlRepository::class
        );

        $this->app->bind(
            ShippingRepositoryInterface::class,
            ShippingRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
