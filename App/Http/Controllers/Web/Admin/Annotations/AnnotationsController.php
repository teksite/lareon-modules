<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Annotations;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Blog\App\Http\Requests\Admin\NewAnnotationRequest;
use Lareon\Modules\Blog\App\Http\Requests\Admin\UpdateAnnotationRequest;
use Lareon\Modules\Blog\App\Logic\AnnotationLogic;
use Lareon\Modules\Blog\App\Models\Annotation;
use Teksite\Lareon\Facade\WebResponse;

class AnnotationsController extends Controller implements HasMiddleware
{
    public function __construct(public AnnotationLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.blog.annotation.read'),
            new Middleware('can:admin.blog.annotation.create', only: ['create', 'store']),
            new Middleware('can:admin.blog.annotation.edit', only: ['edit', 'update']),
            new Middleware('can:admin.blog.annotation.delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annotations = $this->logic->get()->result;
        $count = $this->logic->trashCount()->result;

        return view('blog::admin.pages.annotations.index', compact('annotations' ,'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog::admin.pages.annotations.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewAnnotationRequest $request)
    {
        $result = $this->logic->register($request->validated());
        return WebResponse::byResult($result ,route('admin.blog.annotations.edit', $result->result))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Annotation $annotation)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Annotation $annotation)
    {
        return view('blog::admin.pages.annotations.edit', compact('annotation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnnotationRequest $request, Annotation $annotation)
    {
        $res = $this->logic->change($request->validated(), $annotation);
        return WebResponse::byResult($res, route('admin.blog.annotations.edit', $annotation))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Annotation $annotation)
    {
        $res = $this->logic->delete($annotation);
        return WebResponse::byResult($res, route('admin.blog.annotations.index'))->go();
    }
}
