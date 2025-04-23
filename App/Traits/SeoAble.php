<?php

namespace Lareon\Modules\Seo\App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;
use Lareon\Modules\Seo\App\Models\SeoSitemap;

trait SeoAble
{
    use AddToSitemap, AddToSeoModel;

    public function getSeo(array $types = ['meta', 'schema', 'sitemap']): array
    {
        $types = ['meta', 'schema', 'sitemap'];
        $data = [];
        if (in_array('meta', $types) || in_array('schema', $types)) {
            $meta = $this->seo?->toArray() ?? [];
            if (in_array('schema', $types)) {
                $data['schema'] = $meta['schema'] ?? [];
            }
            if (in_array('meta', $types)) {
                $data['meta'] = Arr::except($meta, ['schema']) ?? [];
            }
        }
        if (in_array('sitemap', $types)) {
            $data['sitemap'] = $this->sitemap?->toArray() ?? [];

        }
        return $data;
    }
}
