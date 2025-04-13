<?php
namespace Lareon\Modules\Questionnaire\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInboxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.questionnaire.inbox.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'note'=>'string|required'
        ];
    }
}
