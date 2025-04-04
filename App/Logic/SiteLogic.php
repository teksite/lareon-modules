<?php

namespace Lareon\Modules\Seo\App\Logic;

use Illuminate\Support\Arr;
use Lareon\Modules\Seo\App\Models\SeoSite;
use Teksite\Handler\Actions\ServiceWrapper;

class SiteLogic
{
    public function getSiteSeo(string $type, ?array $value = null, ?string $state = null)
    {
        return app(ServiceWrapper::class)(function() use ($state, $value, $type) {
            return SeoSite::query()->firstOrCreate(['key' => $type], ['value' => $value, 'state' => $state]);
        });
    }

    public function change(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $type =array_key_first($inputs);
            $state = $inputs[$type]['state'] ?? 0;
            $value = $inputs[$type]['value'];
            SeoSite::query()->updateOrCreate(
               ['key' => $type],
               ['value' => $value, 'state' => $state]
           );
            return $value;
        });
    }
}

