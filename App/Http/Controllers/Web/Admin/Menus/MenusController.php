<?php

namespace Lareon\Modules\Menu\App\Http\Controllers\Web\Admin\Menus;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Menu\App\Http\Requests\Admin\NewMenuRequest;
use Lareon\Modules\Menu\App\Http\Requests\Admin\UpdateMenuRequest;
use Lareon\Modules\Menu\App\Logic\MenusLogic;
use Lareon\Modules\Menu\App\Models\Menu;
use Lareon\Modules\Menu\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Lareon\Facade\WebResponse;

class MenusController extends Controller implements HasMiddleware
{
    public function __construct(public MenusLogic $logic)
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
    public function index()
    {
        $menus = $this->logic->get()->result;

        return view('menu::admin.pages.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->action($this->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewMenuRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res ,route('admin.appearance.menus.index'))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
//        return redirect($menu->path());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('menu::admin.pages.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $res = $this->logic->change($request->validated(), $menu);
        return WebResponse::byResult($res, route('admin.appearance.menus.edit', $menu))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $res = $this->logic->delete($menu);
        return WebResponse::byResult($res, route('admin.appearance.menus.index'))->go();
    }
}
