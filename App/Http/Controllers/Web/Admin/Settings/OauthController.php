<?php

namespace Lareon\Modules\Oauth\App\Http\Controllers\Web\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Oauth\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Oauth\App\Http\Requests\Admin\OauthSettingRequest;
use Lareon\Modules\Oauth\App\Logic\OauthLogic;
use Teksite\Lareon\Facade\WebResponse;

class OauthController extends Controller implements HasMiddleware
{
    public function __construct(public OauthLogic $logic)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.setting.edit'),
        ];
    }

    public function edit()
    {
        $data = $this->logic->getSettings()->result?->value ?? [];
        return view('oauth::admin.pages.settings.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OauthSettingRequest $request)
    {
        $result = $this->logic->change($request->validated());
        return WebResponse::byResult($result)->go();
    }
}
