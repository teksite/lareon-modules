<?php

namespace Lareon\Modules\Menu\App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->register(EventServiceProvider::class);
       // $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         $this->registerCommands();
         $this->registerCommandSchedules();
    }


    /**
         * Register commands in the format of Command::class
         */
        protected function registerCommands(): void
        {
            // $this->commands([]);
        }

        /**
         * Register command Schedules.
         */
        protected function registerCommandSchedules(): void
        {
            // $this->app->booted(function () {
            //     $schedule = $this->app->make(Schedule::class);
            //     $schedule->command('inspire')->hourly();
            // });
        }
}
