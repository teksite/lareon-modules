<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Comment\App\Http\Controllers\Ajax\Client\Comments\CommentsController;


Route::post('/client-submitting/comments/',[CommentsController::class ,'store'])->name('client.submitting.comment');
Route::get('/client-more/comments/',[CommentsController::class ,'load'])->name('client.more.comments');
