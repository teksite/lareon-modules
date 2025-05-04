<?php

namespace Lareon\Modules\Menu\App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'classes'];

    public static function rules()
    {
        return [
            'title' => 'required|max:255|string',
            'classes' => 'nullable|string',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->label = 'menu_'.time();
        });
    }

    public function subs()
    {
        return $this->hasMany(MenuItem::class ,'menu_id');
    }
}
