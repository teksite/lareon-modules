<?php
namespace Lareon\Modules\Page\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Lareon\Modules\Page\App\Models\Page;
use Lareon\Modules\Seo\App\Models\SeoModel;
use Lareon\Modules\Seo\App\Models\SeoSitemap;
use Lareon\Modules\Tag\App\Models\Tag;

class NewPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.page.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(Page::rules(), Tag::rulesForModels()  ,SeoSitemap::rulesForModels() , SeoModel::rulesForModels());

    }
}
