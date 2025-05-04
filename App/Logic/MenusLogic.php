<?php

namespace Lareon\Modules\Menu\App\Logic;

use Illuminate\Support\Arr;
use Lareon\Modules\Menu\App\Models\Menu;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class MenusLogic
{

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Menu::class, ['title'], ...$fetchData);
        });
    }

    public function register(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            return Menu::query()->create($inputs);
        });
    }

    public function change(array $inputs, Menu $menu)
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $menu) {
            $menu->update($inputs);
            return $menu;
        });
    }

    public function delete(Menu $menu)
    {
        return app(ServiceWrapper::class)(function () use ($menu) {
            $menu->delete();
        });
    }

    protected function getModelClass(): string
    {
        return Menu::class;
    }


}


