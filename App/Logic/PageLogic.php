<?php

namespace Lareon\Modules\Page\App\Logic;

use Illuminate\Support\Arr;
use Lareon\CMS\App\Enums\ActionTypesEnum;
use Lareon\CMS\App\Events\CreateOrUpdateInstanceEvent;
use Lareon\Modules\Page\App\Models\Page;
use Teksite\Extralaravel\Traits\TrashMethods;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class PageLogic
{
    use TrashMethods;

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Page::class, ['title'], ...$fetchData);
        });
    }

    public function register(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $page = Page::query()->create(Arr::except($inputs, ['tag', 'meta', 'seo']));
            $page->assignTags($inputs['tags'] ?? null);

            event(new CreateOrUpdateInstanceEvent($page ,$inputs ,ActionTypesEnum::NEW));

            return $page;
        });
    }

    public function change(array $inputs, Page $page)
    {

        return app(ServiceWrapper::class)(function () use ($inputs, $page) {
            $page->update(Arr::except($inputs, ['tag', 'meta', 'seo']));
            $page->assignTags($inputs['tags'] ?? null);
            event(new CreateOrUpdateInstanceEvent($page ,$inputs ,ActionTypesEnum::CHANGE));
            return $page;
        });
    }

    public function delete(Page $page)
    {
        return app(ServiceWrapper::class)(function () use ($page) {

            event(new CreateOrUpdateInstanceEvent($page , type: ActionTypesEnum::DELETE));
            $page->delete();
        });
    }

    protected function getModelClass(): string
    {
        return Page::class;
    }


}

