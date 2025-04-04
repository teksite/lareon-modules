<?php

namespace Lareon\Modules\Blog\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Lareon\CMS\App\Enums\PublishStatusEnum;

class Annotation extends Model
{
    use SoftDeletes;
    protected $table = 'blog_annotations';
    protected $fillable = ['title', 'excerpt', 'body',];


    /**
     * Get the validation rules for creating/updating annotations.
     *
     * @return array<string, string>
     */
    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:blog_annotations,title',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
        ];
    }
}
