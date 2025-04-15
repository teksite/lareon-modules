<?php

namespace Lareon\Modules\Questionnaire\App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lareon\Modules\Questionnaire\App\Events\NewFormRegisteredEvent;
use Lareon\Modules\Questionnaire\App\Listeners\NewFormRegisteredListener;

class EventServiceProvider  extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        NewFormRegisteredEvent::class=>[
            NewFormRegisteredListener::class
        ]
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void
    {
        //
    }
}
