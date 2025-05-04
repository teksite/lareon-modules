<?php

namespace Lareon\Modules\Oauth\App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class OauthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        // $this->app->register(RouteServiceProvider::class);
        $this->setDefault();

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

    /**
     * @return void
     */
    private function setDefault(): void
    {
        Config::set('services.google', [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect' =>/*env('APP_URL').*/'http://127.0.0.1:8000/auth/oauth/callback?type=google',
        ]);
        Config::set('services.github', [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'redirect' =>/*env('APP_URL').*/'http://127.0.0.1:8000/auth/oauth/callback?type=github',
        ]);

        Config::set('services.gitlab', [
            'client_id' => env('GITLAB_CLIENT_ID'),
            'client_secret' => env('GITLAB_CLIENT_SECRET'),
            'redirect' =>/*env('APP_URL').*/'http://127.0.0.1:8000/auth/oauth/callback?type=gitlab',
        ]);
        Config::set('services.linkedin', [
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            'redirect' =>/*env('APP_URL').*/'http://127.0.0.1:8000/auth/oauth/callback?type=linkedin',
        ]);
        Config::set('services.facebook', [
            'client_id' => env('FACEBOOK_CLIENT_ID'),
            'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'redirect' =>/*env('APP_URL').*/'http://127.0.0.1:8000/auth/oauth/callback?type=facebook',
        ]);
        Config::set('services.twitter', [
            'client_id' => env('TWITTER_CLIENT_ID'),
            'client_secret' => env('TWITTER_CLIENT_SECRET'),
            'redirect' =>/*env('APP_URL').*/'http://127.0.0.1:8000/auth/oauth/callback?type=twitter',
        ]);
    }
}
