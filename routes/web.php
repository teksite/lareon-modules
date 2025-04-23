<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Questionnaire\App\Http\Controllers\Web\Client\Receives\ReceivesController;

Route::post('/client-submitting/form/',[ReceivesController::class ,'store'])->name('client.submitting.form')->middleware('throttle:5,1');
