<?php

namespace Lareon\Modules\Seo\App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lareon\Modules\Seo\App\Events\CreateOrUpdateInstanceEvent;
use Lareon\Modules\Seo\App\Listeners\CreateOrUpdateSitemapInstanceListener;

class EventServiceProvider  extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        CreateOrUpdateInstanceEvent::class => [
            CreateOrUpdateSitemapInstanceListener::class
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
