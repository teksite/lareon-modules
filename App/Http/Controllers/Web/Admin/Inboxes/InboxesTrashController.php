<?php

namespace Lareon\Modules\Questionnaire\App\Http\Controllers\Web\Admin\Inboxes;

use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Questionnaire\App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Lareon\Modules\Questionnaire\App\Logic\InboxLogic;
use Teksite\Lareon\Facade\WebResponse;

class InboxesTrashController extends Controller
{


    public function __construct(public InboxLogic $logic)
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.questionnaire.inbox.trash'),
        ];
    }

    public function index()
    {
        $inboxes =$this->logic->getTrashes()->result;
        return view('questionnaire::admin.pages.inboxes.trash', compact('inboxes'));
    }


    public function reinstate($id)
    {
        $result = $this->logic->restoreOne($id);
        return WebResponse::byResult($result, route('admin.questionnaire.inboxes.trash.index'))->go();
    }


    public function prune($id)
    {
        $result = $this->logic->wipeOne($id);
        return WebResponse::byResult($result, route('admin.questionnaire.inboxes.trash.index'))->go();
    }

    public function restore()
    {
        $result = $this->logic->restoreAll();
        return WebResponse::byResult($result, route('admin.questionnaire.inboxes.index'))->go();
    }


    public function flush()
    {
        $result = $this->logic->wipeAll();
        return WebResponse::byResult($result, route('admin..inboxes.index'))->go();
    }

}
