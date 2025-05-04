<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Oauth\App\Http\Controllers\Web\Admin\Settings\OauthController;

Route::prefix('settings/oauth')->name('settings.oauth.')->group(function(){
    Route::get('/', [OauthController::class, 'edit'])->name('edit');
    Route::patch('/', [OauthController::class, 'update'])->name('update');
});
