<?php

use Illuminate\Support\Facades\Route;
use Lareon\Modules\Seo\App\Http\Controllers\Ajax\Admin\Seo\SchemaController;

Route::get('get_schema_model', array(SchemaController::class ,'get_model'))->name('seo.schema_model');
