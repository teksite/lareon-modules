<?php

namespace Lareon\Modules\Fence\App\Providers;

use Illuminate\Support\ServiceProvider;
use Lareon\Modules\Fence\App\Console\Command\MakeFileCommand;

class FenceServiceProvider extends ServiceProvider
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
            $this->commands([
                MakeFileCommand::class
            ]);
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
