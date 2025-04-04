<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Seo\App\Http\Controllers\Ajax\Admin\Seo\SchemaController;

Route::get('seo_get_schema_type', array(SchemaController::class ,'get'))->name('seo.schema_loader');
