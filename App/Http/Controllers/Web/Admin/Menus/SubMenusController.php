<?php

namespace Lareon\Modules\Menu\App\Http\Controllers\Web\Admin\Menus;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Menu\App\Http\Requests\Admin\NewSubMenuRequest;
use Lareon\Modules\Menu\App\Http\Requests\Admin\UpdateSubMenuRequest;
use Lareon\Modules\Menu\App\Logic\SubMenusLogic;
use Lareon\Modules\Menu\App\Models\Menu;
use Lareon\Modules\Menu\App\Models\MenuItem;
use Lareon\Modules\Menu\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Lareon\Facade\WebResponse;

class SubMenusController extends Controller implements HasMiddleware
{
    public function __construct(public SubMenusLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.menu.read'),
            new Middleware('can:admin.menu.create', only: ['create', 'store']),
            new Middleware('can:admin.menu.edit', only: ['edit', 'update']),
            new Middleware('can:admin.menu.delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Menu $menu)
    {
        $items = $this->logic->get($menu)->result;
        return view('menu::admin.pages.submenus.index' ,compact('menu','items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(NewSubMenuRequest $request,Menu $menu)
    {
        $result = $this->logic->register($request->validated() , $menu);

        return WebResponse::byResult($result, route('admin.appearance.menus.sub.index' , $menu))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function update(UpdateSubMenuRequest $request , Menu $menu )
    {
        $result = $this->logic->change($request->validated() , $menu);
        return WebResponse::byResult($result, route('admin.appearance.menus.sub.index' ,$menu))->go();
    }
}
