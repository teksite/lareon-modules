<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Captcha\App\Http\Controllers\Ajax\Client\LocalWebCaptcha;

Route::get('/client-submitting/captcha/load', [LocalWebCaptcha::class,'reload'])->name('client.captcha.load');
Route::get('/client-submitting/captcha/{config}', [LocalWebCaptcha::class,'getCaptcha'])->name('client.captcha.get');
