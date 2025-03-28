<?php
namespace Lareon\Modules\Tag\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Lareon\Modules\Tag\App\Models\Tag;

class NewTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.tag.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Tag::rules();
    }
}
