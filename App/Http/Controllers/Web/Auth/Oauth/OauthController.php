<?php

namespace Lareon\Modules\Oauth\App\Http\Controllers\Web\Auth\Oauth;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Lareon\CMS\App\Logic\UserLogic;
use Lareon\CMS\App\Models\User;
use Lareon\Modules\Oauth\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Lareon\Facade\WebResponse;

class OauthController extends Controller
{

    public function redirect(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(array_keys(config('lareon.oauth.types')))],
        ]);
        return Socialite::driver($data['type'])->redirect();

    }

    public function callback(Request $request)
    {
        $type = $request->get('type');
        if (!$type) return redirect('/login');
        return app(ServiceWrapper::class)(function () use ($type) {
            $data = Socialite::driver('google')->stateless()->user();
            $user = User::firstWhere('email', $data->email);
            if (!$user) {
                $inputs = [
                    'name' => $data->name ?? $data->nickname,
                    'nickname' => $data->nickname ?? $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone ?? null,
                    'featured_image' => $data->avatar,
                    'password' => Str::random(),
                ];
                $user = (new UserLogic())->register($inputs)->result;
            }
            auth()->login($user);
            $res = new ServiceResult('true', $user);
            return WebResponse::byResult($res, $user?->path() ?? url('/'))->go();
        });

    }
}
