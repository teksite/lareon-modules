<?php

namespace Lareon\Modules\Seo\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Lareon\Modules\Seo\App\Events\CreateOrUpdateInstanceEvent;
use Lareon\Modules\Seo\App\Interfaces\HasSeo;
use Lareon\Modules\Seo\App\Models\SeoSitemap;

class CreateOrUpdateSitemapInstanceListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
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

            $this->addToSeoModel($event->instance, Arr::except($data['seo'], ['sitemap']));
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
                    'image' => isset($sitemapData['image']) && count($sitemapData['image']) ? $sitemapData['image'] : [$instance->featured_image],
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

    public function addToSeoModel($instance , $data): void
    {

        $instance->seo()->updateOrCreate([
          "model_type" => get_class($instance),
          "model_id" => $instance->id
        ],
            [
                'title' => $data['meta']['title'] ?? $instance->title ?? $instance->name,
                'description' => $data['meta']['description'] ?? null,
                'conical_url' => $data['meta']['conical_url'] ?? $instance->path(),
                'indexable' => isset($data['meta']['indexable']) ? 'index' :'noindex',
                'followable' => isset($data['meta']['followable']) ? 'follow' :'nofollow',
                'keywords' =>exploding( $data['meta']['keywords'] ?? '')->toArray(),

                'seo_type' =>  $data['schema']['type'] ?? 'webPag',
                'schema' =>  $data['schema'] ?? [],
            ]
        );
    }
}
