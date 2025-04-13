<?php

namespace Lareon\Modules\Seo\App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Lareon\Modules\Seo\App\Models\SeoModel;
use Lareon\Modules\Seo\App\Models\SeoSitemap;

trait AddToSeoModel
{

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoModel::class, 'model');
    }



    public function removeModelSeo(): void
    {
        $this->seo()->delete();
    }

}
