<?php
namespace Lareon\Modules\Seo\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetSchemaContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'seoType' => ['string', Rule::in(array_keys(config('seo.schema-type.pageType')))],
            'instance' => ['nullable'],
            'id' => ['nullable'],
        ];
    }
}
