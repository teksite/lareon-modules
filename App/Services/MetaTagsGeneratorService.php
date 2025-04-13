<?php

namespace Lareon\Modules\Seo\App\Services;

use Illuminate\Database\Eloquent\Model;

class MetaTagsGeneratorService
{
    private array $meta;
    private array $instance;

    public function __construct(public ?Model $model = null, public ?array $manualData = [])
    {
        if ($this->model) {
            $this->meta = $this->model->getSeo(['meta'])['meta'];
            $this->instance = $this->model->toArray();
        } else {
            $this->meta = $manualData['meta'] ?? [];
            $this->instance = $manualData;
        }
    }

    public function generate(): array
    {
        $tags = $this->generateMeta();
        $twitter = $this->generateTwitter();
        $openGraph = $this->generateOpenGraph();
        return array_merge($tags, $twitter, $openGraph);
    }

    public function generateMeta(): array
    {
        $title = $this->meta['title'] ?? $this->instance['title'] ?? $this->instance['name'] ?? config('app.name');
        $description = $this->meta['description'] ?? $this->instance['excerpt'] ?? null;
        $followable = $this->meta['follow'] ?? 'follow';
        $indexable = $this->meta['indexable'] ?? 'index';
        $conical = $this->meta['conical_url'] ?? request()->url();
        $keyword = isset($this->meta['keywords']) ? implode(', ', $this->meta['keywords']) : null;

        $tagHTML = [];
        $tagHTML[] = "<title>$title</title>";
        $tagHTML[] = "<meta name='robots' content='$indexable, $followable'>";
        $tagHTML[] = "<link rel='canonical' href='$conical' />";
        if ($description) $tagHTML[] = "<meta name='description' content='$description'>";
        if ($keyword) $tagHTML[] = "<meta name='keywords' content='$keyword'>";

        return $tagHTML;
    }

    public function generateTwitter(): array
    {
        list($title, $description, $image, $imgAlt, $url, $site) = $this->generalData();

        $twitterHTML = [];
        $twitterHTML[] = "<meta name='twitter:card' content='summary'>";
        $twitterHTML[] = "<meta name='twitter:title' content='$title'>";
        $twitterHTML[] = "<meta name='twitter:site' content='$site'>";
        $twitterHTML[] = "<meta name='twitter:url' content='$url'>";
        if ($description) $twitterHTML[] = "<meta name='twitter:description' content='$description'>";
        if ($image) $twitterHTML[] = "<meta name='twitter:image' content='$image'>";
        if ($imgAlt) $twitterHTML[] = "<meta name='twitter:alt' content='$imgAlt'>";

        return $twitterHTML;
    }

    public function generateOpenGraph(): array
    {
        list($title, $description, $image, $imgAlt, $url, $site) = $this->generalData();

        $openGraphHTML = [];
        $openGraphHTML[] = "<meta property='og:type' content='website'>";
        $openGraphHTML[] = "<meta property='og:title' content='$title'>";
        $openGraphHTML[] = "<meta property='og:site_name' content='$site'>";
        $openGraphHTML[] = "<meta property='og:url' content='$url'>";
        if ($description) $openGraphHTML[] = "<meta property='og:description' content='$description'>";
        if ($image) $openGraphHTML[] = "<meta property='og:image' content='$image'>";
        if ($imgAlt) $openGraphHTML[] = "<meta property='og:image:alt' content='$imgAlt'>";

        return $openGraphHTML;
    }

    public function generalData(): array
    {
        $title = $this->meta['title'] ?? $this->instance['title'] ?? $this->instance['name'] ?? config('app.name');
        $description = $this->meta['description'] ?? $this->instance['excerpt'] ?? null;
        $image = $this->instance['featured_image'] ?? $this->instance['avatar'] ?? null;
        $imgAlt = $this->instance['title'] ?? $this->instance['name'] ?? null;
        $url = $this->meta['conical_url'] ?? request()->url();
        $site = config('app.name');
        return array($title, $description, $image, $imgAlt, $url, $site);
    }
}
