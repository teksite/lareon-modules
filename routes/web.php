<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Blog\App\Http\Controllers\Web\Client\Posts\PostsController;

Route::prefix('blog')->name('blog.posts.')->group(callback: function (){
    Route::get('/', [PostsController::class,'index'])->name('index');
    Route::get('/{post:slug}', [PostsController::class,'show'])->name('show');
});
