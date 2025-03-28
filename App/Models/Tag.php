<?php

namespace Lareon\Modules\Tag\App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title'];

    /**
     * @return array
     */
    public static function rules(): array
    {
        return [
            'title' => 'required|string|unique:tags,title',
        ];
    }
}
