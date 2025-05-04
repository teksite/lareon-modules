<?php

namespace Lareon\Modules\Gadget\App\Http\Controllers\Web\Admin\Gadgets;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Gadget\App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Lareon\Modules\Gadget\App\Logic\GadgetLogic;
use Teksite\Lareon\Facade\WebResponse;

class TrashGadgetsController extends Controller  implements HasMiddleware
{
    public function __construct(public GadgetLogic $logic)
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.gadget.trash'),
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
        return WebResponse::byResult($result, route('admin.gadgets.trash.index'))->go();
    }


    public function prune($id)
    {
        $result = $this->logic->wipeOne($id);
        return WebResponse::byResult($result, route('admin.gadgets.trash.index'))->go();
    }

    public function restore()
    {
        $result = $this->logic->restoreAll();
        return WebResponse::byResult($result, route('admin.gadgets.index'))->go();
    }


    public function flush()
    {
        $result = $this->logic->wipeAll();
        return WebResponse::byResult($result, route('admin.gadgets.index'))->go();
    }

}
