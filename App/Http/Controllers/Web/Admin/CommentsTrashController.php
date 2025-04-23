<?php

namespace Lareon\Modules\Comment\App\Http\Controllers\Web\Admin;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Comment\App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Lareon\Modules\Comment\App\Logic\CommentsLogic;
use Teksite\Lareon\Facade\WebResponse;

class CommentsTrashController extends Controller implements HasMiddleware
{
    public function __construct(public CommentsLogic $logic)
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.comment.trash'),
        ];
    }

    public function index()
    {
        $comments =$this->logic->getTrashes()->result;
        return view('comment::admin.pages.comments.trash', compact('comments'));
    }


    public function reinstate($id)
    {
        $result = $this->logic->restoreOne($id);
        return WebResponse::byResult($result, route('admin.comments.trash.index'))->go();
    }


    public function prune($id)
    {
        $result = $this->logic->wipeOne($id);
        return WebResponse::byResult($result, route('admin.comments.trash.index'))->go();
    }

    public function restore()
    {
        $result = $this->logic->restoreAll();
        return WebResponse::byResult($result, route('admin.comments.index'))->go();
    }


    public function flush()
    {
        $result = $this->logic->wipeAll();
        return WebResponse::byResult($result, route('admin.comments.index'))->go();
    }

}
