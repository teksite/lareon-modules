<?php

namespace Lareon\Modules\Seo\App\Logic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Lareon\Modules\Seo\App\Models\SeoModel;

use Teksite\Handler\Actions\ServiceWrapper;


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
                'JobPosition' => view('seo::components.types.job-position', compact('value', 'name')),
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

    public function generate(Model $model)
    {
        $data = $model->getSeo(['meta', 'schema']);
        $tags = $this->generateMeta($data['meta'] ?? [], $model->toArray());
        $twitter = $this->generateTwitter($data['meta'] ?? [], $model->toArray());
        dd($twitter);
    }

    public function generateMeta(array $meta, array $instance)
    {
        $title = $meta['title'] ?? $instance['title'] ?? $instance['name'] ?? config('app.name');
        $description = $meta['description'] ?? $instance['excerpt'] ?? null;

        $followable = $meta['follow'] ?? 'follow';
        $indexable = $meta['indexable'] ?? 'index';
        $conical = $meta['conical_url'] ?? request()->url();
        $keyword = isset($meta['keywords']) ? implode(', ', $meta['keywords']) : null;

        $tagHTML = "<title>$title</title> \n";
        $tagHTML .= "<meta name='robots' content='$indexable, $followable'> \n";
        $tagHTML .= "<link rel='canonical' href='$conical' /> \n";
        if ($description) $tagHTML .= "<meta name='description' content='$description'> \n";
        if ($keyword) $tagHTML .= "<meta name='keywords' content='$keyword'> \n";

        return $tagHTML;
    }

    public function generateTwitter(array $meta, array $instance)
    {
        $title = $meta['title'] ?? $instance['title'] ?? $instance['name'];
        $description = $meta['description'] ?? $instance['excerpt'] ?? null;
        $image = $instance['featured_image'] ?? $instance['avatar'] ?? null;
        $imgAlt = $instance['title'] ?? $instance['name'] ?? null;
        $url = $meta['conical_url'] ?? request()->url();
        $site = config('app.name');


        $twitterHTML = "<meta name='twitter:card' content='summary'> \n";
        $twitterHTML .= "<meta name='twitter:title' content='$title'> \n";
        $twitterHTML .= "<meta name='twitter:site' content='$site'> \n";
        $twitterHTML .= "<meta name='twitter:url' content='$url'> \n";
        if ($description) $twitterHTML .= "<meta name='twitter:description' content='$description'> \n";
        if ($description) $twitterHTML .= "<meta name='twitter:image' content='$image'> \n";
        if ($description) $twitterHTML .= "<meta name='twitter:alt' content='$imgAlt'> \n";

        return $twitterHTML;
    }
}
