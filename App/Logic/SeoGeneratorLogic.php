<?php

namespace Lareon\Modules\Seo\App\Logic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Lareon\Modules\Seo\App\Models\SeoModel;

use Lareon\Modules\Seo\App\Services\MetaTagsGeneratorService;
use Lareon\Modules\Seo\App\Services\SchemaGeneratorService;
use Lareon\Modules\Seo\App\Services\WebsiteGeneratorService;
use Spatie\SchemaOrg\Graph;
use Teksite\Handler\Actions\ServiceWrapper;


class SeoGeneratorLogic
{
    public function generate(null|Model $model=null ,null|array $manualData=[])
    {
        return app(ServiceWrapper::class)(function () use ($manualData, $model) {
            $meta =(new MetaTagsGeneratorService($model , $manualData))->generate();
            $schema =(new SchemaGeneratorService($model , $manualData))->generate();
            $site =(new WebsiteGeneratorService())->generate();
            $metaScript=implode("", $meta);

            $graph=(new Graph());
            foreach ([...$schema , ...$site] as $item){
                $graph->set($item);
            };
            return $metaScript ."\n".$graph->toScript() ."\n\n" .'<!-- SINA ZANGIBAND 09126037279 -->'."\n\n";

       }, hasTransaction: false);
    }
}
