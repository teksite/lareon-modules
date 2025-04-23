<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Comment\App\Http\Controllers\Web\Client\CommentsController;


Route::post('/client-submitting/comments/',[CommentsController::class ,'store'])->name('client.submitting.comment');
