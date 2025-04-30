<?php

namespace Lareon\Modules\Captcha\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;
use Lareon\Modules\Captcha\App\Rules\CaptchaRule;
use Lareon\Modules\Captcha\App\Services\CaptchaService;
use Lareon\Modules\Captcha\App\Services\Facades\Captcha;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        // $this->app->register(RouteServiceProvider::class);

        $this->registerCaptcha();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->bootCaptchaRules();
        $this->bootDirectives();
    }

    public function bootCaptchaRules()
    {
        $validator = $this->app['validator'];
    }

    public function bootDirectives()
    {
        Blade::directive('captcha', function () {
            return view("captcha::components.load");
        });
    }


    protected function registerCaptcha(): void
    {
        $this->app->alias(Captcha::class, 'Captcha');

        // Bind the ImageManager with an explicit driver
        if (!$this->app->bound('Intervention\Image\ImageManager')) {
            $this->app->singleton('Intervention\Image\ImageManager', function ($app) {
                // Determine which driver to use, defaulting to 'gd'
                $driver = config('captcha.driver', 'gd') === 'imagick' ? new ImagickDriver() : new GdDriver();

                return new ImageManager($driver);
            });
        }

        // Bind captcha
        $this->app->bind('captcha', function ($app) {
            return new Captcha(
                $app['Illuminate\Filesystem\Filesystem'],
                $app['Illuminate\Contracts\Config\Repository'],
                $app['Intervention\Image\ImageManager'],
                $app['Illuminate\Session\Store'],
                $app['Illuminate\Hashing\BcryptHasher'],
                $app['Illuminate\Support\Str']
            );
        });
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
