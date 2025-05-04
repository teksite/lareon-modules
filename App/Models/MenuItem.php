<?php

namespace Lareon\Modules\Menu\App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class MenuItem extends Model
{
    use HasRecursiveRelationships;

    protected $fillable = ['menu_id', 'parent_id', 'position', 'title', 'subtitle', 'pre_icon', 'next_icon', 'image', 'url', 'classes', 'attributes',];

    public static function rules()
    {
        return [
            'parent_id' => 'nullable|string',
            'position' => 'nullable|string',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'pre_icon' => 'nullable|string',
            'next_icon' => 'nullable|string',
            'image' => 'nullable|string',
            'url' => 'nullable|string',
            'classes' => 'nullable|string',
            'attributes' => 'nullable|string',
        ];
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
