<?php

namespace Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Seo\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Seo\App\Logic\GeneralLogic;

class GeneralController extends Controller implements HasMiddleware
{
    public function __construct(public GeneralLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.seo.genereal.edit'),
        ];
    }
}
