<?php

namespace Lareon\Modules\Tag\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider  extends ServiceProvider
{
    protected string $moduleName = 'Tag';

    public function boot(): void
       {
           parent::boot();
       }

       /**
        * Define the routes for the module.
        */
       public function map(): void
       {
           $this->mapApiRoutes();
           $this->mapWebRoutes();
       }

       /**
        * Define the "web" routes for the application.
        *
        * These routes all receive session state, CSRF protection, etc.
        */
       protected function mapWebRoutes(): void
       {
          if (file_exists(module_path($this->moduleName, '/routes/web.php'))) {
              Route::middleware('web')->group(module_path($this->moduleName, '/routes/web.php'));
          }
       }

       /**
        * Define the "api" routes for the application.
        *
        * These routes are typically stateless.
        */
       protected function mapApiRoutes(): void
       {
            if (file_exists(module_path($this->moduleName, '/routes/api.php'))) {
                Route::middleware('api')->prefix('api')->name('api.')->group(module_path($this->moduleName, '/routes/api.php'));
            }
       }
}
