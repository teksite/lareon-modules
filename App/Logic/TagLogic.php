<?php

namespace Lareon\Modules\Tag\App\Logic;

use Illuminate\Support\Arr;
use Lareon\Modules\Tag\App\Models\Tag;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class TagLogic
{
    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Tag::class, ['title'], ...$fetchData);
        });
    }

    public function register(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            return Tag::query()->create($input);
        });
    }

    public function change(array $input, Tag $tag)
    {
        return app(ServiceWrapper::class)(function () use ($input, $tag) {
            $tag->update($input);
            return $tag;
        });
    }

    public function delete(Tag $tag)
    {
        return app(ServiceWrapper::class)(function () use ($tag) {
            $tag->delete();
        });
    }
}


