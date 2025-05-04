<?php

namespace Lareon\Modules\Oauth\App\Logic;

use Illuminate\Support\Arr;
use Lareon\CMS\App\Models\Setting;
use Teksite\Handler\Actions\ServiceWrapper;

class OauthLogic
{
    public function getSettings()
    {
        return app(ServiceWrapper::class)(function () {
            $oauth = Setting::query()->firstWhere(['key' => 'oauth']);

            return $oauth;
        }, hasTransaction: false);
    }

    public function change(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $oauth = Setting::query()->updateOrCreate([
                'key' => 'oauth',
            ], [
                'value' => $inputs['oauth'],
            ]);

            return $oauth;
        });

    }

    public function get()
    {
        return app(ServiceWrapper::class)(function () {
            $oauths = Setting::query()->firstWhere(['key' => 'oauth'])?->value ?? [];
            return collect($oauths)->filter(function ($details, $key) {
                return !(empty($details['enable']) && empty($details['secret_key']) && empty($details['client_id']));
            });

        }, hasTransaction: false);
    }
}

