<?php

namespace Lareon\Modules\Blog\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Cast\ImageCast;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Teksite\Extralaravel\Casts\SlugCast;

class Category extends Model
{
    use HasRecursiveRelationships;

    protected $table = 'blog_categories';
    protected $fillable = ['parent_id', 'title', 'slug', 'excerpt', 'body', 'featured_image',];

    protected $casts = [
        'slug' => SlugCast::class,
        'featured_image' => ImageCast::class,
    ];


    /**
     * @return string[]
     */
    static function rules(): array
    {
        return [
            'parent_id' => 'nullable',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
            'featured_image' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the validation rules specific to model relationships.
     *
     * @return array<string, string>
     */
    public static function rulesForModels(): array
    {
        return [
            'categories' => 'required|array',
            'categories.*' => 'required|exists:blog_categories,id',
        ];
    }


    /**
     * @return string|null
     */
    public function path(): ?string
    {
        return Route::has('blog.category.show') ? route('blog.category.show', $this) : null;
    }

    /**
     * @return BelongsToMany
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class ,'blog_category_post');
    }

}
