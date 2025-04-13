<?php

namespace Lareon\Modules\Questionnaire\App\Http\Controllers\Web\Admin\Forms;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Questionnaire\App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Lareon\Modules\Questionnaire\App\Logic\FormLogic;
use Teksite\Lareon\Facade\WebResponse;

class FormsTrashController extends Controller implements HasMiddleware
{
    public function __construct(public FormLogic $logic)
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.questionnaire.form.trash'),
        ];
    }

    public function index()
    {
        $forms = $this->logic->getTrashes()->result;
        return view('questionnaire::admin.pages.forms.trash', compact('forms'));
    }


    public function reinstate($id)
    {
        $result = $this->logic->restoreOne($id);
        return WebResponse::byResult($result, route('admin.questionnaire.forms.trash.index'))->go();
    }


    public function prune($id)
    {
        $result = $this->logic->wipeOne($id);
        return WebResponse::byResult($result, route('admin.questionnaire.forms.trash.index'))->go();
    }

    public function restore()
    {
        $result = $this->logic->restoreAll();
        return WebResponse::byResult($result, route('admin.questionnaire.forms.index'))->go();
    }


    public function flush()
    {
        $result = $this->logic->wipeAll();
        return WebResponse::byResult($result, route('admin.questionnaire.forms.index'))->go();
    }

}
