<?php

namespace Lareon\Modules\Tag\App\Http\Controllers\Web\Admin;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use Lareon\Modules\Tag\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Tag\App\Http\Requests\Admin\NewTagRequest;
use Lareon\Modules\Tag\App\Http\Requests\Admin\UpdateTagRequest;
use Lareon\Modules\Tag\App\Logic\TagLogic;
use Lareon\Modules\Tag\App\Models\Tag;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Lareon\Facade\WebResponse;

class TagsController extends Controller implements HasMiddleware
{

    public function __construct(public TagLogic $logic)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.tag.read'),
            new Middleware('can:admin.tag.create', only: ['create', 'store']),
            new Middleware('can:admin.tag.edit', only: ['edit', 'update']),
            new Middleware('can:admin.tag.delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res=$this->logic->get();
        $tags=$res->result;
        return view('tag::admin.pages.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tag::admin.pages.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewTagRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res, route('admin.tags.index'))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        if(Route::has('tags.show')){
            return redirect()->route('tags.show', compact('tag'));
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('tag::admin.pages.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $res = $this->logic->change($request->validated() , $tag);
        return WebResponse::byResult($res, route('admin.tags.edit', $tag))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $res = $this->logic->delete($tag);
        return WebResponse::byResult($res, route('admin.tags.index'))->go();
    }
}
