<?php

namespace Lareon\Modules\Questionnaire\App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'questionnaire_forms';

    protected $fillable = ['title', 'body', 'template', 'has_file', 'response_client', 'active',];


    public static function rules(): array
    {
        return [
            'title'=>'required|string|max:100|unique:questionnaire_forms,title',
            'body'=>'nullable|string',
            'template'=>'nullable|string|max:6',
            'has_file'=>'sometimes|in:0,1',
            'response_client'=>'sometimes|in:0,1',
            'active'=>'sometimes|in:0,1',
        ];
    }

    public function inbox(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Inbox::class, 'form_id');
    }

    public  function validationRules(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(FormRule::class, 'form_id');
    }
    public  function announcement(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(FormAnnouncement::class, 'form_id');
    }
}
