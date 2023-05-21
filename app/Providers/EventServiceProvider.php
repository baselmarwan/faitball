<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\AcademyCreated;
use App\Events\AcademyDeleted;
use App\Listeners\SendAcademyCreatedNotification;
use App\Listeners\SendAcademyDeletedNotification;
use Illuminate\Redis\RedisManager;
use App\Events\TrainerAddedToAcademy;
use App\Listeners\NotifyOtherTrainers;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AcademyCreated::class => [
            SendAcademyCreatedNotification::class,
        ],
        AcademyDeleted::class => [
            SendAcademyDeletedNotification::class,
        ],
        TrainerAddedToAcademy::class => [
            NotifyOtherTrainers::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
{
    parent::boot();

    $this->app->bind(
        \Illuminate\Contracts\Broadcasting\Broadcaster::class,
        \App\Broadcasting\PusherBroadcaster::class
    );

    $this->app->singleton('redis', function ($app) {
        return new RedisManager($app, 'predis', $app['config']['database.redis']);
    });

    Event::listen(TrainerAddedToAcademy::class, [NotifyOtherTrainers::class, 'handle']);
}


    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
