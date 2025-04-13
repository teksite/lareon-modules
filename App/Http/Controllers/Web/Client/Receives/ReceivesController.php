<?php

namespace Lareon\Modules\Questionnaire\App\Http\Controllers\Web\Client\Receives;

use Lareon\Modules\Questionnaire\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Questionnaire\App\Http\Requests\NewRegistrationRequest;
use Lareon\Modules\Questionnaire\App\Logic\InboxLogic;
use Teksite\Lareon\Facade\WebResponse;

class ReceivesController extends Controller
{

    public function __construct(public InboxLogic $logic)
    {
    }

    public function store(NewRegistrationRequest $request)
    {
        $res = $this->logic->register($request->form, $request->validated());
        return WebResponse::byResult($res)->go();
    }
}
