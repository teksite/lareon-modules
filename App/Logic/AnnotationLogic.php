<?php

namespace Lareon\Modules\Blog\App\Logic;

use Illuminate\Support\Arr;
use Lareon\Modules\Blog\App\Models\Annotation;
use Teksite\Extralaravel\Traits\TrashMethods;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class AnnotationLogic
{
    use TrashMethods;

    public function get(mixed $fetchData=[])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Annotation::class ,['title'] ,...$fetchData);
        });
    }

    public function register(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            return Annotation::query()->create($input);
        });
    }

    public function change(array $input, Annotation $annotation)
    {
        return app(ServiceWrapper::class)(function () use ($input, $annotation) {
            $annotation->update($input);
            return $annotation;
        });
    }

    public function delete(Annotation $annotation)
    {
        return app(ServiceWrapper::class)(function () use ($annotation) {
            $annotation->delete();
        });
    }

    protected function getModelClass(): string
    {
        return Annotation::class;
    }
}

