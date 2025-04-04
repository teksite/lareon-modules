<?php

namespace Lareon\Modules\Seo\App\Models;

use Illuminate\Database\Eloquent\Model;
use Teksite\Extralaravel\Casts\JsonCast;

class SeoModel extends Model
{
    protected $fillable = ["model_type", "model_id", "title", "description", "keywords", "conical_url", "indexable", "followable", "seo_type", "schema",];

    protected $casts = [
        "keywords" => JsonCast::class,
        "schema" => JsonCast::class,
    ];

    static function rulesForModels():array
    {
        return [
            "seo.meta.title"=>'nullable|string',
            "seo.meta.description"=>'nullable|string',
            "seo.meta.keywords"=>'nullable|string',
            "seo.meta.conical_url"=>'nullable|string',
            "seo.meta.indexable"=>'nullable|sometimes|in:0,1',
            "seo.meta.followable"=>'nullable|sometimes|in:0,1',


            "seo.schema"=>'nullable|array',
            "seo.schema.*"=>'nullable',
        ];
    }
}
