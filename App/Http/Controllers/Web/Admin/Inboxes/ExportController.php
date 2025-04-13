<?php

namespace Lareon\Modules\Questionnaire\App\Http\Controllers\Web\Admin\Inboxes;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Questionnaire\App\Http\Controllers\Controller;
use Lareon\Modules\Questionnaire\App\Http\Requests\Admin\ExportInboxRequest;
use Lareon\Modules\Questionnaire\App\Logic\ExportInboxLogic;
use Lareon\Modules\Questionnaire\App\Models\Form;

class ExportController extends Controller implements HasMiddleware
{
    public function __construct(public ExportInboxLogic $logic)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.questionnaire.inbox.export'),
        ];
    }


    public function index()
    {
        $forms = Form::all();
        return view('questionnaire::admin.pages.export.index', compact('forms'));
    }


    public function export(ExportInboxRequest $request)
    {
        $services = $this->logic->export($request->validated());
        return $services->data;
    }
}
