<?php

namespace Lareon\Modules\Page\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Lareon\CMS\App\Cast\ImageCast;
use Lareon\CMS\App\Enums\PublishStatusEnum;
use Lareon\CMS\App\Models\Scopes\PublishStatusScope;
use Lareon\Modules\Seo\App\Interfaces\HasSeo;
use Lareon\Modules\Seo\App\Traits\AddSeo;
use Lareon\Modules\Tag\App\Traits\HasTag;
use Teksite\Extralaravel\Casts\SlugCast;

class Page extends Model implements HasSeo
{
    use SoftDeletes, HasTag, AddSeo;

    protected $fillable = ['parent_id', 'title', 'slug', 'body', 'excerpt', 'featured_image', 'template', 'publish_status', 'published_at'];

    protected $casts = [
        'slug' => SlugCast::class,
        'featured_image' => ImageCast::class,
        'publish_status' => PublishStatusEnum::class,
        'published_at' => 'datetime',
    ];

    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
            'featured_image' => 'nullable|string|max:255',
            'publish_status' => ['required', 'string', Rule::in(array_column(PublishStatusEnum::cases(), 'value'))],
            'published_at' => 'nullable|date',
            'template' => 'nullable|string',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new PublishStatusScope);
    }


    public function path(): string
    {
        return route('pages.show', $this);
    }

    public function breadcrumb(): array
    {
        $breadcrumb = [];
        $breadcrumb[$this->attributes['title']] = $this->path();

        return $breadcrumb;
    }


    public function sitemapGroup(): string
    {
        return 'pages';
    }
}
