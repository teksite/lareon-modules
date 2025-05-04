<?php
namespace Lareon\Modules\Menu\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Lareon\Modules\Menu\App\Models\Menu;

class NewMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.menu.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Menu::rules();
    }
}
