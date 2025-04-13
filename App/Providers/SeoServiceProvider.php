<?php

namespace Lareon\Modules\Seo\App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Lareon\Modules\Seo\App\Console\Command\GenerateSitemapCommand;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->register(EventServiceProvider::class);
       $this->registerConfig();
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
                 GenerateSitemapCommand::class
             ]);
        }

        /**
         * Register command Schedules.
         */
        protected function registerCommandSchedules(): void
        {
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('sitemap:regenerate')->dailyAt('02:00');
            });
        }

        protected function registerConfig(): void{
            $configPath = config_path('seo-schema-type.php'); // Path to the published file
            $this->mergeConfigFrom(
                file_exists($configPath) ? $configPath :module_path('Seo','config/seo-schema-type.php'), 'seo.schema-type');

            $configPath = config_path('seo-price-range.php'); // Path to the published file
            $this->mergeConfigFrom(
                file_exists($configPath) ? $configPath :module_path('Seo','config/seo-price-range.php'), 'seo.price-range');
        }

}
