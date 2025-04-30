<?php

namespace Lareon\Modules\Captcha\App\Services\Facades;

use Illuminate\Support\Facades\Facade;
use Lareon\Modules\Captcha\App\Services\CaptchaService;


class Captcha extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return  CaptchaService::class;
    }
}
