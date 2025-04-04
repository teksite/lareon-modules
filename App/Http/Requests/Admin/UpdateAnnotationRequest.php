<?php
namespace Lareon\Modules\Blog\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lareon\Modules\Blog\App\Models\Annotation;

class UpdateAnnotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.blog.annotation.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(Annotation::rules() ,['title'=>['required','string','max:255',Rule::unique('blog_annotations' ,'title')->ignore($this->annotation->id)]]);

    }
}
