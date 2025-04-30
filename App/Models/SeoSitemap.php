<?php

namespace Lareon\Modules\Seo\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class SeoSitemap extends Model
{
    protected $fillable = ["model_id", "model_type", "group", "url", "priority", "changefreq", "lastmod", "image", "active",    ];

    protected $casts=[
        "lastmod"=>"datetime",
        "changefreq"=>"string",
        "image"=>'json',
        "video"=>'json',
    ];

    static function rulesForModels() :array
    {
       return [
           "seo.sitemap.priority"=>'string|required',
           "seo.sitemap.changefreq"=>['required','string'],
           "seo.sitemap.images"=>'nullable|sometimes|array',
           "seo.sitemap.videos"=>'nullable|sometimes|array',
       ];
    }
}
