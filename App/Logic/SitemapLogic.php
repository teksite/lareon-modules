<?php

namespace Lareon\Modules\Seo\App\Logic;

use Lareon\Modules\Page\App\Models\Page;
use Lareon\Modules\Seo\App\Models\SeoSitemap;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\SitemapGenerator;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Tags\Sitemap as SitemapTag;
use Illuminate\Support\Facades\File;

class SitemapLogic
{
    private const DEFAULT_MAIN_FILENAME = 'sitemap.xml';
    private const EXCLUDED_ADMIN_PATH = 'tkadmin';

    private readonly string $directory;
    private readonly string $mainPath;

    public function __construct()
    {
        $this->directory = public_path('sitemaps');
        $this->mainPath = $this->directory . DIRECTORY_SEPARATOR . self::DEFAULT_MAIN_FILENAME;

        $this->ensureSitemapsDirectoryExists();
    }

    public function generateSitemaps(): ServiceResult
    {
        return app(ServiceWrapper::class)(function () {
            $this->removeSitemaps();
            $crawlMode = config('lareon.cms.sitemap.crawl');
            $fileMode = config('lareon.cms.sitemap.file');

            return match ($crawlMode) {
                'database' => $this->generateFromDatabase($fileMode),
                'auto' => $this->generateFromCrawler(),
                default => throw new \InvalidArgumentException("Invalid sitemap crawl mode: {$crawlMode}"),
            };
        });
    }


    private function ensureSitemapsDirectoryExists(): void
    {
        app(ServiceWrapper::class)(function () {
            File::ensureDirectoryExists($this->directory);
        });
    }

    private function generateFromDatabase(string $fileMode): bool
    {
        match ($fileMode) {
            'single' => $this->generateSingleSitemap(),
            'index' => $this->generateGroupedSitemaps(),
            default => throw new \InvalidArgumentException("Invalid sitemap file mode: {$fileMode}"),
        };

        return true;
    }

    private function generateFromCrawler(): bool
    {
        SitemapGenerator::create('/')
            ->shouldCrawl(fn(UriInterface $url) => !str_contains($url->getPath(), self::EXCLUDED_ADMIN_PATH))
            ->writeToFile($this->mainPath);

        return true;
    }

    private function generateSingleSitemap(): void
    {
        $this->buildSitemap($this->getQuery())
            ->writeToFile($this->mainPath);
    }

    private function generateGroupedSitemaps(): void
    {
        $sitemapIndex = SitemapIndex::create();
        $groups = $this->getUniqueGroups();

        foreach ($groups as $group) {

            $fileName = $this->buildOneGroupSitemap($group);

            $sitemapIndex->add(
                SitemapTag::create("/sitemaps/{$fileName}")
                    ->setLastModificationDate(now())
            );
        }

        $sitemapIndex->writeToFile($this->mainPath);
    }

    private function buildOneGroupSitemap($group): string
    {
        $fileName = "sitemap_{$group}.xml";

        $filePath = $this->directory . DIRECTORY_SEPARATOR . $fileName;

        $this->buildSitemap($this->getQuery()->where('group', $group))
            ->writeToFile($filePath);
        return $fileName;
    }

    private function buildSitemap($query): Sitemap
    {
        $sitemap = Sitemap::create();

        $query->cursor()->each(function (SeoSitemap $seoSitemap) use ($sitemap) {
            $sitemap->add($this->createUrl($seoSitemap));
        });

        return $sitemap;
    }

    private function createUrl(SeoSitemap $seoSitemap): Url
    {
        $url = Url::create($seoSitemap->url)
            ->setPriority($seoSitemap->priority)
            ->setChangeFrequency($seoSitemap->changefreq)
            ->setLastModificationDate($seoSitemap->lastmod ?? now());
        $this->addImagesToUrl($url, $seoSitemap->image);

        return $url;
    }

    private function addImagesToUrl(Url $url, $images): void
    {
        if (is_string($images)) {
            $url->addImage($images);
            return;
        }

        if ($images instanceof \Illuminate\Support\Collection) {
            $images->each(fn($image) => $url->addImage($image));
        }
    }

    private function getUniqueGroups(): array
    {
        return $this->getQuery()
            ->distinct('group')
            ->pluck('group')
            ->all();
    }

    private function getQuery()
    {
        return SeoSitemap::query()->whereNotNull('active')->where('active', "<=", now());
    }

    private function removeSitemaps(): void
    {
        foreach (glob(public_path('sitemaps/*')) as $file) {
            if (is_file($file)) unlink($file);
        }
    }
}
