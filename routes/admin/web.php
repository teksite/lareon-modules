<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Annotations\AnnotationsController;
use Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Annotations\AnnotationsTrashController;
use Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Categories\CategoriesController;
use Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Posts\PostsController;
use Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Posts\PostsTrashController;

Route::prefix('blog')->name('blog.')->group(function () {
    Route::resource('categories', CategoriesController::class);

    Route::trashResource('posts', PostsTrashController::class);
    Route::resource('posts', PostsController::class);

    Route::trashResource('annotations', AnnotationsTrashController::class);
    Route::resource('annotations', AnnotationsController::class);

});

