<?php

namespace Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Seo\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Seo\App\Http\Requests\Admin\UpdateSiteSeoRequest;
use Lareon\Modules\Seo\App\Logic\RobotLogic;
use Lareon\Modules\Seo\App\Logic\SiteLogic;
use Teksite\Lareon\Facade\WebResponse;

class SiteController extends Controller implements HasMiddleware
{
    public function __construct(public SiteLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.seo.site.edit'),
        ];
    }


    public function edit()
    {
        $type = request()->input('type', 'website');

        if (!in_array($type, ['website', 'organization', 'local_business'])) abort(404);

        $data = $this->logic->getSiteSeo($type)->result;
        if ($type === 'organization') return view('seo::admin.pages.site.org', compact('data'));
        if ($type === 'local_business') return view('seo::admin.pages.site.local', compact('data'));
        return view('seo::admin.pages.site.general', compact('data'));
    }


    public function update(UpdateSiteSeoRequest $request)
    {
        $res = $this->logic->change($request->validated());

       return WebResponse::byResult($res)->go();

    }

}
