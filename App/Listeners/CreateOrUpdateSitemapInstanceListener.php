<?php

namespace Lareon\Modules\Seo\App\Listeners;

use Lareon\CMS\App\Events\CreateOrUpdateInstanceEvent;
use Lareon\Modules\Seo\App\Interfaces\HasSeo;
use Lareon\Modules\Seo\App\Models\SeoSitemap;

class CreateOrUpdateSitemapInstanceListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(CreateOrUpdateInstanceEvent $event): void
    {
        $instance = $event->instance;
        $data=$event->data;
        if ($instance instanceof HasSeo) {
            $this->addToSitemap($event->instance, $data['seo']['sitemap'] ?? []);
        }
    }

    public function addToSitemap($instance, array $sitemapData): void
    {
        if ($instance->path() && count($sitemapData)) {
            if ($instance->publish_status === 'published' || $instance->publish_status === 'postponed') {
                $active = $instance->published_at ?? $this->created_at ?? now();
            } else {
                $active = null;
            }
           SeoSitemap::query()->updateOrCreate(
                [
                    'model_type' => get_class($instance),
                    'model_id' => $instance->id
                ], [
                    'group' => $instance->sitemapGroup() ?? 'general',
                    'url' => $instance->path(),
                    'priority' => $sitemapData['priority'] ?? 0.5,
                    'changefreq' => $sitemapData['changefreq'] ?? 'yearly',
                    'lastmod' => $instance->published_at ?? $instance->updated_at ?? $instance->created_at ?? now(),
                    'image' => isset($sitemapData['images']) && count($sitemapData['images']) ? $sitemapData['images'] : [$instance->featured_image],
                    'videos' => isset($sitemapData['videos']) && count($sitemapData['videos']) ? $sitemapData['videos'] : null,
                    'active' => $active,
                ]
            );
        }
        else{
            $this->removeFromSitemap($instance);
        }
    }
    public function removeFromSitemap($instance): void
    {
        SeoSitemap::query()->where('model_id', $instance->id)->where('model_type', get_class($this))->delete();
    }
}
