<?php

namespace Lareon\Modules\Blog\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Lareon\CMS\App\Cast\ImageCast;
use Lareon\CMS\App\Enums\PublishStatusEnum;
use Lareon\CMS\App\Models\Scopes\PublishStatusScope;
use Lareon\CMS\App\Models\User;
use Lareon\Modules\Comment\App\Models\Comment;
use Lareon\Modules\Comment\App\Traits\Commentable;
use Lareon\Modules\Seo\App\Interfaces\HasSeo;
use Lareon\Modules\Seo\App\Traits\SeoAble;
use Lareon\Modules\Seo\App\Traits\AddToSitemap;
use Lareon\Modules\Tag\App\Traits\Taggable;
use Teksite\Extralaravel\Casts\SlugCast;

class Post extends Model implements HasSeo
{
    use SoftDeletes, Taggable, SeoAble, Commentable;

    protected $table = 'blog_posts';

    protected $fillable = ['user_id', 'title', 'slug', 'body', 'excerpt', 'featured_image', 'publish_status', 'published_at', 'template',];

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
            'slug' => 'required|string|max:255|unique:blog_posts,slug',
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
        return route('blog.posts.show', $this);
    }

    public function breadcrumb(): array
    {
        $breadcrumb= [];
        if (Route::has('blog.posts.index')) $breadcrumb[__('blog')] = route('blog.posts.index');
        if (Route::has('blog.posts.show')) $breadcrumb[$this->attributes['title']] = $this->path();

        return $breadcrumb;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'blog_category_post');
    }

    /**
     * get attributes(columns value) of categories
     *
     * @param array<string>|string $columns
     * @return Collection
     */
    public function getCategories(array|string $columns = ['id', 'title']): Collection
    {
        $columns = is_array($columns) ? $columns : [$columns];
        return $this->categories()->select($columns)->get();
    }


    public function sitemapGroup(): string
    {
        return 'blog_post';
    }

}
