<?php

namespace Lareon\Modules\Seo\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Lareon\Modules\Seo\App\Enums\ChangeFreqEnum;
use Teksite\Extralaravel\Casts\JsonCast;

class SeoSitemap extends Model
{
    protected $fillable = ["model_id", "model_type", "group", "url", "priority", "changefreq", "lastmod", "image", "active",    ];

    protected $casts=[
        "lastmod"=>"datetime",
        "changefreq"=>"string",
        "image"=>JsonCast::class,
    ];

    static function rulesForModels() :array
    {
       return [
           "seo.sitemap.priority"=>'string|required',
           "seo.sitemap.changefreq"=>['required','string'],
           "seo.sitemap.image"=>'nullable|sometimes|array',
           "seo.sitemap.video"=>'nullable|sometimes|array',
       ];
    }
}
