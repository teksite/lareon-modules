<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Gadget\App\Http\Controllers\Web\Admin\Gadgets\GadgetsController;
use Lareon\Modules\Gadget\App\Http\Controllers\Web\Admin\Gadgets\TrashGadgetsController;

Route::prefix('appearance')->name('appearance.')->group(function () {
    Route::trashResource('gadgets', TrashGadgetsController::class);
    Route::resource('gadgets', GadgetsController::class);
});
