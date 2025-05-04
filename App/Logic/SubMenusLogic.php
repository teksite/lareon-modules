<?php

namespace Lareon\Modules\Menu\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Lareon\Modules\Menu\App\Models\Menu;
use Lareon\Modules\Menu\App\Models\MenuItem;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class SubMenusLogic
{
    public function get(Menu $menu)
    {
        return app(ServiceWrapper::class)(function () use ($menu) {
            return app(FetchDataService::class)(function () use ($menu) {
                $items =MenuItem::where('menu_id',$menu->id)->tree()->get();
                $tree = $items->toTree();
                return $tree;
            }

            );
        } ,hasTransaction:false);
    }
    public function register(array $inputs , Menu $menu )
    {

        return app(ServiceWrapper::class)(function () use ($menu, $inputs) {
            $max = DB::table('menu_items')->where('menu_id', $menu->id)->max('position');

            $inputs['position'] = $max ? $max + 1 : 0;
            $inputs['parent_id'] = null;
            $menu->subs()->create($inputs);
        });
    }
    public function change(array $inputs , Menu $menu )
    {
        return app(ServiceWrapper::class)(function () use ($menu, $inputs) {
            $items = $inputs['items'];
            $updateItems = [];
            $newItems = [];
            $existingIds = $menu->subs()->pluck('id')->toArray();
            $newItemIds = collect($items)->pluck('id')->filter()->toArray();

            foreach ($items as $key=>$item) {
                if (isset($item['id'])) {
                    $item['menu_id']=$menu->id;
                    $updateItems[] = $item;
                }else{
                    $newItems[$key] = $item;
                    $newItems[$key]['menu_id'] =$menu->id;

                }
            }

            DB::table('menu_items')->upsert($updateItems, ['id']);
            DB::table('menu_items')->insert($newItems);

            $idDiff = array_diff($existingIds, $newItemIds);
            if (!empty($idDiff))  $menu->subs()->whereIn('id', $idDiff)->delete();

        });
    }
}

