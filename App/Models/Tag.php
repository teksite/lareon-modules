<?php

namespace Lareon\Modules\Tag\App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title'];

    public $timestamps = false;

    /**
     *  Get the validation rules for creating/updating tags.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'title' => 'required|string|unique:tags,title',
        ];
    }

    /**
     * Get the validation rules specific to model relationships.
     *
     * @return array<string, string>
     */
    public static function rulesForModels(): array
    {
        return [
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
        ];
    }
}
