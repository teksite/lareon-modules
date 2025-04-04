<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Annotations;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Lareon\Modules\Blog\App\Logic\AnnotationLogic;
use Teksite\Lareon\Facade\WebResponse;

class AnnotationsTrashController extends Controller implements HasMiddleware
{
    public function __construct(public AnnotationLogic $logic)
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.blog.annotation.trash'),
        ];
    }

    public function index()
    {
        $annotations =$this->logic->getTrashes()->result;
        return view('blog::admin.pages.annotations.trash', compact('annotations'));
    }


    public function reinstate($id)
    {
        $result = $this->logic->restoreOne($id);
        return WebResponse::byResult($result, route('admin.blog.annotations.trash.index'))->go();
    }


    public function prune($id)
    {
        $result = $this->logic->wipeOne($id);
        return WebResponse::byResult($result, route('admin.blog.annotations.trash.index'))->go();
    }

    public function restore()
    {
        $result = $this->logic->restoreAll();
        return WebResponse::byResult($result, route('admin.blog.annotations.index'))->go();
    }


    public function flush()
    {
        $result = $this->logic->wipeAll();
        return WebResponse::byResult($result, route('admin.blog.annotations.index'))->go();
    }

}
