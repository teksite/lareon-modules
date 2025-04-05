<?php

namespace Lareon\Modules\Blog\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lareon\Modules\Blog\App\Models\Category;
use Lareon\Modules\Blog\App\Models\Post;
use Lareon\Modules\Seo\App\Models\SeoModel;
use Lareon\Modules\Seo\App\Models\SeoSitemap;
use Lareon\Modules\Tag\App\Models\Tag;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.blog.post.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(Post::rules(), Tag::rulesForModels() , Category::rulesForModels() ,SeoSitemap::rulesForModels() , SeoModel::rulesForModels(),
            ['slug' => ['required','string','max:255',Rule::unique('blog_posts' ,'slug')->ignore($this->post->id)]],
        );

    }
}
