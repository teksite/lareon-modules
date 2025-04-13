<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo\GeneralController;
use Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo\OtherSeoController;
use Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo\RobotController;
use Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo\SiteController;
use Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo\SitemapsController;


Route::prefix('seo')->name('seo.')->group(function () {
    Route::prefix('robot_txt')->name('robot.')->group(function () {
        Route::get('/', [RobotController::class, 'edit'])->name('edit');
        Route::patch('/', [RobotController::class, 'update'])->name('update');
    });

    Route::prefix('site')->name('site.')->group(function () {
        Route::get('/', [SiteController::class, 'edit'])->name('edit');
        Route::patch('/', [SiteController::class, 'update'])->name('update');
    });

//    Route::get('/others', [OtherSeoController::class, 'index'])->name('others.index');

    Route::prefix('sitemap')->name('sitemap.')->group(function () {
        Route::get('/', [SitemapsController::class, 'index'])->name('index');
        Route::patch('/', [SitemapsController::class, 'generate'])->name('generate');
        Route::get('/scan', [SitemapsController::class, 'scan'])->name('scan');
    });

});
