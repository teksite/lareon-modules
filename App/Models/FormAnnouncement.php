<?php

namespace Lareon\Modules\Questionnaire\App\Models;

use Illuminate\Database\Eloquent\Model;

class FormAnnouncement extends Model
{
    protected $table = 'questionnaire_form_announcements';

    protected $fillable = ['form_id', 'emails', 'phones', 'telegram_ids', 'urls',];


    public static function rulesForModels(): array
    {
        return [
            'announcements.emails' => 'nullable|string',
            'announcements.phones' => 'nullable|string',
            'announcements.telegram_ids' => 'nullable|string',
            'announcements.urls' => 'nullable|string',
        ];

    }

    public function form()
    {
        return $this->belongsTo(Form::class , 'form_id');
    }
}
