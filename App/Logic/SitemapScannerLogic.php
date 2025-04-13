<?php

namespace Lareon\Modules\Seo\App\Logic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Lareon\Modules\Seo\App\Models\SeoSitemap;
use Teksite\Handler\Actions\ServiceWrapper;

class SitemapScannerLogic
{
    private const DEFAULT_PRIORITY = 0.6;
    private const DEFAULT_GROUP = 'other';
    private const DEFAULT_CHANGEFREQ = 'yearly';

    public function scan()
    {
        return app(ServiceWrapper::class)(function () {

            collect(config('modules', []))
                ->pluck('sitemap.singles')
                ->filter()
                ->flatten(1)
                ->each(fn(array $item) => $this->processSingle($item));


            collect(config('modules', []))
                ->pluck('sitemap.models')
                ->filter()
                ->flatten(1)
                ->each(fn(array $item) => $this->processModel($item));
        });
    }

    private function processModel(array $item): void
    {
        if (empty($item['model'])) {
            return;
        }

        $modelClass = $item['model'];
        $config = $this->getModelConfig($item);

        $this->getUnmappedInstances($modelClass)
            ->each(fn(Model $instance) => $this->createSitemapEntry($instance, $config));
    }

    private function processSingle(array $item): void
    {
        if (empty($item['url']) && empty($item['route'])) return;
        $this->registerToSitemapDB($item);


    }

    private function getModelConfig(array $item): array
    {
        return [
            'priority' => $item['priority'] ?? self::DEFAULT_PRIORITY,
            'group' => $item['group'] ?? self::DEFAULT_GROUP,
            'changefreq' => $item['changefreq'] ?? self::DEFAULT_CHANGEFREQ,
        ];
    }

    private function getUnmappedInstances(string $modelClass): Collection
    {
        return resolve($modelClass)
            ->whereDoesntHave('sitemap')
            ->get();
    }

    private function createSitemapEntry(Model $instance, array $config): void
    {
        if (!$instance->path()) {
            return;
        }

        $lastmod = $this->determineLastModified($instance);

        $instance->sitemap()->create([
            'priority' => $config['priority'],
            'group' => $config['group'],
            'url' => $instance->path(),
            'lastmod' => $lastmod,
            'changefreq' => $config['changefreq'],
            'image' => $this->getFeaturedImage($instance),
            'active' => now(),
        ]);
    }

    private function determineLastModified(Model $instance): \DateTimeInterface
    {
        $lastmod = $instance->updated_at ?? now();
        return ($instance->published_at && $instance->published_at > $lastmod)
            ? $instance->published_at
            : $lastmod;
    }

    private function getFeaturedImage(Model $instance): ?array
    {
        return $instance->featured_image ? [$instance->featured_image] : null;
    }

    private function registerToSitemapDB(array $item): void
    {
        $path=match(true){
            isset($item['url'])=> url($item['url']),
            isset($item['route'])=> route($item['route']),
        };
        SeoSitemap::query()->create([
            'priority' => $item['priority'] ?? 0.6,
            'group' => $item['group'] ?? self::DEFAULT_GROUP,
            'url' =>$path,
            'lastmod' => $item['lastmod'] ?? null,
            'changefreq' => $item['changefreq'] ?? self::DEFAULT_CHANGEFREQ,
            'image' => $item['image'] ?? null,
            'active' => $item['active'] ?? now(),
        ]);
    }
}
