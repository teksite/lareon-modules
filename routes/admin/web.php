<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Fence\App\Http\Controllers\Web\ADmin\Ip\IpsController;

Route::name('settings.ips.')->prefix('settings/ips')->group(function () {
    Route::get('/', [IpsController::class, 'index'])->name('index');
    Route::post('/', [IpsController::class, 'store'])->name('store');
    Route::delete('/', [IpsController::class, 'destroy'])->name('destroy');
});
