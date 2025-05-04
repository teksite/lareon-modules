<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Gadget\App\Http\Controllers\Ajax\Client\Gadgets\GadgetsController;

Route::post('/client-submitting/gadget', [GadgetsController::class,'load'])->name('gadgets.load');

