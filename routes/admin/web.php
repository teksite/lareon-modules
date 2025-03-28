<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Tag\App\Http\Controllers\Web\Admin\TagsController;

Route::resource('tags', TagsController::class);
