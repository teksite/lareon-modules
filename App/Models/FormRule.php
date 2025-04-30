<?php

namespace Lareon\Modules\Questionnaire\App\Models;

use Illuminate\Database\Eloquent\Model;

class FormRule extends Model
{
    protected $table = 'questionnaire_form_rules';

    protected $fillable = ['form_id', 'rules'];

    protected $casts = [
        'rules' => 'json',
    ];

    public static function rulesForModels(): array
    {
        return [
            'rules' => 'nullable|array',
            'rules.*.*' => 'string|required',
        ];
    }

    public function form()
    {
        return $this->belongsTo(Form::class ,'form_id');
    }
}
