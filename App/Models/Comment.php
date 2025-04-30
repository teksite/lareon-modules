<?php

namespace Lareon\Modules\Comment\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lareon\CMS\App\Models\User;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Teksite\Extralaravel\Rules\NoHtmlRule;

class Comment extends Model
{
    use SoftDeletes ,HasRecursiveRelationships;

    protected $fillable = ['user_id', 'parent_id', 'model_id', 'model_type', 'message', 'confirmed','name','email' ,'ip_address'];

    public static function rulesForModels() :array
    {
        return [
            'message'=>['required','string' , new NoHtmlRule()],
            'data_info.fullname'=>'prohibited'
        ];
    }
    public static function rules() :array
    {
        return [
            'message'=>['required','string' , new NoHtmlRule()],
            'confirmed'=>'sometimes|in:1,0',
            'parent_id'=>'nullable',
        ];
    }

   protected static function booted()
   {
       parent::booted();
       static::addGlobalScope('hasModel', function (Builder $builder) {
           $builder->whereHas('model');
       });

   }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function model()
    {
        return $this->morphTo('model');
    }

    public function path()
    {
        return $this->model->path();
    }
    public function getTitleAttribute()
    {
        return $this->model->title ?? $this->model->name ?? '';
    }
}
