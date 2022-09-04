<?php

namespace App\Providers;

use App\Events\ProcessFile\ProcessFileEvent;
use App\Events\ProcessFile\ProcessFileEventInterface;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ProcessFileEventInterface::EVENT_NAME => [
            ProcessFileEvent::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
