<?php

namespace Lareon\Modules\Questionnaire\App\Http\Controllers\Web\Admin\Inboxes;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Carbon;
use Lareon\Modules\Questionnaire\App\Http\Controllers\Controller;
use Lareon\Modules\Questionnaire\App\Logic\AnalyticInboxLogic;
use Lareon\Modules\Questionnaire\App\Models\Form;

class AnalyticsController extends Controller implements HasMiddleware
{
    public function __construct(public AnalyticInboxLogic $logic)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.questionnaire.inbox.read')
        ];
    }

    public function show(Request $request)
    {
        $res=$this->logic->generate($request->get('fromDate'), $request->get('toDate'), $request->get('range'))->result;
        return view('questionnaire::admin.pages.analytics.show' ,['chartData'=>$res['chart']]);
    }

}
