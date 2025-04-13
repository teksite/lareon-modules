<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Page\App\Http\Controllers\Web\Client\Pages\PagesController;

Route::get('/{page:slug}', [PagesController::class, 'show'])->name('pages.show');
