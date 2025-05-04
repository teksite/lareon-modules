@props(['menu'])
@php
if(is_string($menu)){
    $menu=\Lareon\Modules\Menu\App\Models\Menu::query()->firstWhere('label',$menu);
}
$items = $menu instanceof \Lareon\Modules\Menu\App\Models\Menu ? (new \Lareon\Modules\Menu\App\Logic\SubMenusLogic($menu))->get($menu)->result :[];
@endphp
@if(count($items))
    <x-menu::tree-items :items="$items" />
@endif
