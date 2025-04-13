<?php

namespace Lareon\Modules\Page\App\Http\Controllers\Web\Admin\Pages;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Page\App\Http\Requests\Admin\NewPageRequest;
use Lareon\Modules\Page\App\Http\Requests\Admin\UpdatePageRequest;
use Lareon\Modules\Page\App\Logic\PageLogic;
use Lareon\Modules\Page\App\Models\Page;
use Lareon\Modules\Page\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Lareon\Facade\WebResponse;

class PagesController extends Controller implements HasMiddleware
{
    public function __construct(public PageLogic $logic)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.page.read'),
            new Middleware('can:admin.page.create', only: ['create', 'store']),
            new Middleware('can:admin.page.edit', only: ['edit', 'update']),
            new Middleware('can:admin.page.delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = $this->logic->get()->result;
        $count = $this->logic->trashCount()->result;

        return view('page::admin.pages.pages.index', compact('pages' ,'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page::admin.pages.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewPageRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res ,route('admin.pages.edit', $res->result))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return redirect($page->path());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('page::admin.pages.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $res = $this->logic->change($request->validated(), $page);
        return WebResponse::byResult($res, route('admin.pages.edit', $page))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $res = $this->logic->delete($page);
        return WebResponse::byResult($res, route('admin.pages.index'))->go();
    }
}
