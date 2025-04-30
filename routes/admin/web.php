<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Captcha\App\Http\Controllers\Web\Admin\Settings\CaptchaController;

Route::get('settings/captcha', [CaptchaController::class, 'index'])->name('settings.captcha.read');
