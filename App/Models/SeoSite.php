<?php

namespace Lareon\Modules\Seo\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Teksite\Extralaravel\Casts\JsonCast;
use function Laravel\Prompts\select;

class SeoSite extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (app()->getLocale() === 'en') $this->table = 'seo_site_en';
    }

    protected $table = 'seo_site';

    protected $fillable = ['state' ,'key', 'value'];

    protected $casts=[
        'state'=>'boolean',
        'value'=>JsonCast::class,
    ];

    public static function rules()
    {
        return [
            'website'=>[
                'website.state'=>'sometimes|in:0,1',
                'website.value'=>'required|array',
                'website.value.title'=>'required|string',
                'website.value.description'=>'required|string',
                'website.value.currency'=>['required','string',Rule::in(array_keys(config('currency')))],
                'website.value.language'=>['required','string',Rule::in(array_keys(config('lang')))],
            ],
            'local_business'=>[
                'local_business.state'=>'sometimes|in:0,1',
                'local_business.value.type'=>['required','string'],
                'local_business.value'=>'required|array',
                'local_business.value.title'=>'required|string',
                'local_business.value.description'=>'nullable|string',
                'local_business.value.image'=>'required|string',
                'local_business.value.id_url'=>'required|string|url',
                'local_business.value.telephone'=>'required|string',
                'local_business.value.price_range'=>['required','string',Rule::in(array_keys(config('seo.price-range' ,['$','$$','$$$','$$$$'])))],
                'local_business.value.address'=>'required|array',
                'local_business.value.address.country'=>['required','string',Rule::in(array_keys(config('area' , [])))],
                'local_business.value.address.city'=>'required|string',
                'local_business.value.address.street'=>'nullable|string',
                'local_business.value.address.zip_code'=>'nullable|string',
                'local_business.value.geo'=>'required|array',
                'local_business.value.geo.*'=>'nullable|string',
                'local_business.value.openingHours'=>'required|array',
                'local_business.value.openingHours.*'=>'nullable|array',
                'local_business.value.sameas'=>'nullable|array|sometimes',
                'local_business.value.sameas.*'=>'string|nullable',
            ],
            'organization'=>[
                'organization.state'=>'sometimes|in:0,1',
                'organization.value'=>'required|array',
                'organization.value.type'=>['required','string'],
                'organization.value.title'=>'required|string',
                'organization.value.alternative_title'=>'required|string',
                'organization.value.description'=>'nullable|string',
                'organization.value.image'=>'required|string',
                'organization.value.sameas'=>'nullable|array|sometimes',
                'organization.value.sameas.*'=>'string|nullable',
                'organization.value.contactPoint'=>'nullable|array|sometimes',
                'organization.value.contactPoint.*'=>'nullable',
            ]
        ];
    }
}
