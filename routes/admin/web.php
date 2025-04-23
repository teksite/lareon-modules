<?php


use Illuminate\Support\Facades\Route;
use Lareon\Modules\Comment\App\Http\Controllers\Web\Admin\CommentsController;
use Lareon\Modules\Comment\App\Http\Controllers\Web\Admin\CommentsTrashController;

Route::delete('comments/delete_many', [CommentsController::class,'destroyMany'])->name('comments.delete.items');
Route::trashResource('comments', CommentsTrashController::class);
Route::resource('comments', CommentsController::class);
