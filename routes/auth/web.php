<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Oauth\App\Http\Controllers\Web\Auth\Oauth\OauthController;

Route::middleware('guest')->prefix('/oauth')->name('oauth.')->group(function () {
    Route::get('/callback',[OauthController::class,'callback'])->name('callback');
    Route::get('/',[OauthController::class,'redirect'])->name('redirect');
});
