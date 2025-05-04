<?php

namespace Lareon\Modules\Gadget\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Gadget extends Model
{
    protected $fillable = ['label', 'title', 'body','template'];

    public function scopeGetGadget(Builder $query, string $label)
    {
        return $query->firstWhere('label', $label) ? $query->firstWhere('label', $label)->body : null;
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|string',
            'body' => 'nullable|string',
            'template' => 'nullable|string',
        ];
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->label = 'gadget_'.time();
        });
    }


}
