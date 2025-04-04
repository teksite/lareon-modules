<?php

namespace Lareon\Modules\Seo\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Lareon\Modules\Seo\App\Models\SeoModel;
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

class SchemaLogic
{
    public function getView(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $type = $inputs['seoType'];

            $seoData = isset($inputs['instance'], $inputs['id'])
                ? SeoModel::query()->where('model_type', $inputs['instance'])->where('model_id', $inputs['id'])->first()->toArray()
                : collect([])->toArray();
            $meta = Arr::except($seoData, 'schema');
            $value = [
                'title' => $meta['title'], 'description' => $meta['description'],
                ...$seoData['schema'],
            ];
            $name = 'seo[schema]';

            $view = match ($type) {
                'Article' => view('seo::components.types.article', compact('value', 'name')),
                'Blog' => view('seo::components.types.blog', compact('value', 'name')),
                'Event' => view('seo::components.types.event', compact('value', 'name')),
                'FAQPage' => view('seo::components.types.faq', compact('value', 'name')),
                'HowTo' => view('seo::components.types.howto', compact('value', 'name')),
                'JobPosition' => view('seo::components.types.JobPosition', compact('value', 'name')),
                'Person' => view('seo::components.types.person', compact('value', 'name')),
                'SoftwareApplication' => view('seo::components.types.software', compact('value', 'name')),
                'VideoObject' => view('seo::components.types.video', compact('value', 'name')),
                'Product' => view('seo::components.types.product', compact('value', 'name')),
                'ContactPage' => view('seo::components.types.contact', compact('value', 'name')),
                'Recipe' => view('seo::components.types.recipe', compact('value', 'name')),
                default => view('seo::components.types.webpage', compact('value', 'name')),
            };
            return $view->render();
        }, withHandler: false);

    }
}
