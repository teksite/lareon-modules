<?php

namespace Lareon\Modules\Blog\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider  extends ServiceProvider
{
    protected string $moduleName = 'Blog';

    public function boot(): void
       {
           parent::boot();
       }

       /**
        * Define the routes for the module.
        */
       public function map(): void
       {

       }


}
