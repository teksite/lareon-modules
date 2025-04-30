<?php

namespace Lareon\Modules\Captcha\App\Http\Controllers\Web\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Captcha\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Captcha\App\Logic\CaptchaLogic;
use Teksite\Lareon\Facade\WebResponse;

class CaptchaController extends Controller implements HasMiddleware
{
    public function __construct()
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.setting.read'),
        ];
    }

    public function index()
    {
        return view('captcha::admin.pages.captcha.index');
    }
}
