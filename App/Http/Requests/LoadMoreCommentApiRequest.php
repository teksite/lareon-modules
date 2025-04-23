<?php
namespace Lareon\Modules\Comment\App\Http\Requests;

use Teksite\Extralaravel\Http\ApiFormRequest;

class LoadMoreCommentApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->ajax();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bind' => 'string|required',
            'offset' => 'numeric|required',
            'identify' => 'numeric|required',
        ];
    }


    public function prepareForValidation(): void
    {
        $this->merge([
            'bind' =>  decrypt($this->input('bind')),
            'identify' =>  decrypt($this->input('identify')),
        ]);
    }


}
