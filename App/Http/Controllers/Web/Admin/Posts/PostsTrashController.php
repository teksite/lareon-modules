<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Posts;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Lareon\Modules\Blog\App\Logic\PostLogic;
use Teksite\Lareon\Facade\WebResponse;

class PostsTrashController extends Controller implements HasMiddleware
{
    public function __construct(public PostLogic $logic)
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.blog.post.trash'),
        ];
    }

    public function index()
    {
        $posts =$this->logic->getTrashes()->result;
        return view('blog::admin.pages.posts.trash', compact('posts'));
    }


    public function reinstate($id)
    {
        $result = $this->logic->restoreOne($id);
        return WebResponse::byResult($result, route('admin.blog.posts.trash.index'))->go();
    }


    public function prune($id)
    {
        $result = $this->logic->wipeOne($id);
        return WebResponse::byResult($result, route('admin.blog.posts.trash.index'))->go();
    }

    public function restore()
    {
        $result = $this->logic->restoreAll();
        return WebResponse::byResult($result, route('admin.blog.posts.index'))->go();
    }


    public function flush()
    {
        $result = $this->logic->wipeAll();
        return WebResponse::byResult($result, route('admin.blog.posts.index'))->go();
    }

}
