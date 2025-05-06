<?php

namespace Lareon\Modules\Fence\App\Models;

use Illuminate\Database\Eloquent\Model;

class RestrictIp extends Model
{
    protected $fillable = ['ip_address', 'type'];

    public static function rules(): array
    {
        return [
            'ip_address' => 'required|ip|unique:restrict_ips,ip_address',
            'type'=>'string|in:white,black'
        ];
    }

}
