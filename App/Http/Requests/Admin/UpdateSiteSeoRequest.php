<?php
namespace Lareon\Modules\Seo\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Lareon\Modules\Seo\App\Models\SeoSite;
use Teksite\Extralaravel\Rules\NeverPassRule;

class UpdateSiteSeoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && $admin = auth()->user()->can('admin.seo.site.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $allRules=  $rules=SeoSite::rules();
        $type=request()->input('type') ?? null;
        if($type == 'website'){
            return $allRules['website'];
        }elseif($type == 'local_business'){
            return $allRules['local_business'];
        }elseif($type == 'organization'){
            return $allRules['organization'];
        }
        return [
            'type' => ['required', new NeverPassRule()],
        ];

    }
}
