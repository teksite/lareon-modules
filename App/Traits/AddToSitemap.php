<?php

namespace Lareon\Modules\Seo\App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Lareon\Modules\Seo\App\Models\SeoSitemap;

trait AddToSitemap
{
    abstract public function sitemapGroup(): string;

    public function sitemap(): MorphOne
    {
        return $this->morphOne(SeoSitemap::class, 'model');
    }


    public function addToSitemap(array $data, string $group = 'general'): void
    {
        if ($this->path()) {
            if ($this->publish_status === 'published' || $this->publish_status === 'postponed') {
                $active = $this->published_at ?? $this->created_at ?? now();
            } else {
                $active = null;
            }

            SeoSitemap::query()->updateOrCreate(
                [
                    'model_type' => get_class($this),
                    'model_id' => $this->id
                ], [
                    'group' => $this->sitemapGroup() ?? $group,
                    'url' => $this->path(),
                    'priority' => $data['priority'],
                    'changefreq' => $data['changefreq'],
                    'lastmod' => $this->published_at ?? $this->updated_at ?? $this->created_at ?? now(),
                    'image' => $data['image'],
                    'active' => $active,
                ]
            );
        }
    }

    public function removeSitemap(): void
    {
        $this->sitemap()->delete();
    }

}
