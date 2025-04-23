<?php
namespace Lareon\Modules\Questionnaire\App\Http\Requests;

use Illuminate\Support\Facades\Crypt;
use Lareon\Modules\Questionnaire\App\Models\Form;
use Lareon\Modules\Questionnaire\App\Models\Inbox;
use Teksite\Extralaravel\Http\ApiFormRequest;

class NewRegistrationApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        $this->loadForm();
        $formRules = $this->form->validationRules->rules->pluck('rules', 'field')->toArray();
        return array_merge(Inbox::rulesForModels(), $formRules);
    }

    protected function passedValidation(): void
    {
        $this->merge(['form' => $this->form]);
    }

    protected function loadForm(): void
    {
        $identify = $this->input('data_info.identify');

        if (is_null($identify)) abort(403, 'something gos wrong, suspicion behavior');

        try {
            $formId = Crypt::decrypt($identify);
            $this->form = Form::findOrFail($formId);
        } catch (\Exception $e) {
            abort(404, 'something goes wrong');
        }
    }
}
