<?php

namespace Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Seo\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Seo\App\Logic\SitemapLogic;
use Teksite\Lareon\Facade\WebResponse;

class SitemapsController extends Controller implements HasMiddleware
{
    public function __construct(public SitemapLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.seo.sitemap.edit'),
        ];
    }

    public function index()
    {
        return view('seo::admin.pages.sitemap.index');
    }

    public function generate()
    {
        $res = $this->logic->generateSitemaps();
        return WebResponse::byResult($res ,route('admin.seo.sitemap.index'))->go();
    }

}
