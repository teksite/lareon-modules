<?php

namespace Lareon\Modules\Seo\App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;
use Lareon\Modules\Seo\App\Models\SeoSitemap;

trait AddSeo
{
    use AddToSitemap, AddToSeoModel;

    public function getSeo()
    {
        $meta=$this->seo->toArray();
        $sitemap=$this->sitemap->toArray();
        return [
            'meta'=>Arr::except($meta, ['schema']) ?? [],
            'schema'=>Arr::only($meta, ['schema']) ?? [],
            'sitemap'=>$sitemap,
        ];
    }
}
