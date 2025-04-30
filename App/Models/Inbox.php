<?php

namespace Lareon\Modules\Questionnaire\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lareon\CMS\App\Models\User;

class Inbox extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_inboxes';

    protected $fillable = ['form_id', 'data', 'url', 'note', 'user_id', 'ip_address', 'read_at'];

    protected $casts = [
        'data' => 'json',
        'read_at' => 'datetime',
        'note' => 'json',
    ];

    public static function rules(): array
    {
        return [
            "form_title" => 'required|string|max:150|exists:questionnaire_forms,title',
            "data" => 'array',
            "url" => 'nullable|string',
            "note" => 'nullable|string',
            "read_at" => 'nullable|datetime',
            "user_id" => 'nullable|integer',
        ];
    }

    public static function rulesForModels(): array
    {
        return [
            'data_info' => 'array|required',
            'data_info.identify' => 'required|string',
            'data_info.url' => 'required|string',
            'data_info.fullname' => 'prohibited',
        ];

    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function form(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
