<?php
namespace Lareon\Modules\Comment\App\Http\Requests;

use Illuminate\Validation\Rule;
use Lareon\Modules\Comment\App\Models\Comment;
use Lareon\Modules\Comment\App\Rules\CheckParentCommentRule;
use Teksite\Extralaravel\Http\ApiFormRequest;

class NewCommentApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (config('lareon.comment.allow') === 'auth') {
            return auth()->check() && auth()->user()->can('client-comment-create');
        } elseif (config('lareon.comment.allow') === 'any') {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $preRules = Comment::rulesForModels();

        $authRules = config('lareon.comment.allow') === 'any' ? [
            'name' => 'required|string',
            'email' => 'required|string|email',
        ] : [];
        $modelRule = [
            'data_info' => 'required|array',
            'data_info.identify' =>['required', Rule::exists((new ($this->input('data_info.type')))->getTable(), 'id')],
            'data_info.type' => 'required|string',
            'parent' => ['nullable','numeric' , new CheckParentCommentRule()],
        ];
        return array_merge($preRules, $authRules, $modelRule);
    }


    public function prepareForValidation(): void
    {
        $this->merge([
            'data_info' => [
                'type' => decrypt($this->input('data_info.type')),
                'identify' => decrypt($this->input('data_info.identify')),
            ],
        ]);
    }
}
