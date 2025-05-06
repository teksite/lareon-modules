<?php

namespace Lareon\Modules\Fence\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lareon\Modules\Fence\App\Models\RestrictIp;

class DeleteIpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('admin.setting.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isFileStorage = config('lareon.fence.storage', 'file') === 'file';

        return [
            'ip_address' => ['required'],
            'type' => 'required|string|in:whitelist,blacklist',
        ];
    }

    private function uniqueIpAddressRule(bool $isFileStorage)
    {
        if ($isFileStorage) {
            $ips=$this->loadFile();
            return Rule::notIn($ips[$this->type]);
        }

        return Rule::unique(RestrictIp::class, 'ip_address');
    }

    /**
     * Load IP addresses from file storage.
     *
     * @return array
     * @throws \RuntimeException
     */
    private function loadFile(): array
    {
        $filePath = storage_path('app/ip_address.php');

        if (!file_exists($filePath)) {
            return [];
        }
        return require $filePath;
    }
}
