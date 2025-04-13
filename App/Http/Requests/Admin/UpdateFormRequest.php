<?php
namespace Lareon\Modules\Questionnaire\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lareon\Modules\Questionnaire\App\Models\Form;
use Lareon\Modules\Questionnaire\App\Models\FormAnnouncement;
use Lareon\Modules\Questionnaire\App\Models\FormRule;

class UpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.questionnaire.form.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return array_merge(Form::rules(),FormAnnouncement::rulesForModels(), FormRule::rulesForModels(),
            ['title' => ['required','string','max:255',Rule::unique('questionnaire_forms' ,'title')->ignore($this->form->id)]],
        );
    }
}
