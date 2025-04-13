<?php

namespace Lareon\Modules\Questionnaire\App\Models;

use Illuminate\Database\Eloquent\Model;
use Teksite\Extralaravel\Casts\JsonCast;

class FormRule extends Model
{
    protected $table = 'questionnaire_form_rules';

    protected $fillable = ['form_id', 'rules'];

    protected $casts = [
        'rules' => JsonCast::class,
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
