<?php

namespace Lareon\Modules\Questionnaire\App\Http\Controllers\Ajax\Client\Receives;

use Lareon\Modules\Questionnaire\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Questionnaire\App\Http\Requests\NewRegistrationApiRequest;
use Lareon\Modules\Questionnaire\App\Http\Requests\NewRegistrationRequest;
use Lareon\Modules\Questionnaire\App\Logic\InboxLogic;
use Teksite\Lareon\Facade\JsonResponse;
use Teksite\Lareon\Facade\WebResponse;

class ReceivesController extends Controller
{
    public function __construct(public InboxLogic $logic)
    {
    }

    public function store(NewRegistrationApiRequest $request)
    {
        $res = $this->logic->register($request->form, $request->validated());
        return JsonResponse::byResult($res)->reply();
    }
}
