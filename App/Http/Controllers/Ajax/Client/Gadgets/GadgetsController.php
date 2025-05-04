<?php

namespace Lareon\Modules\Gadget\App\Http\Controllers\Ajax\Client\Gadgets;

use Lareon\Modules\Gadget\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Gadget\App\Http\Requests\LoadGadgetApiRequest;
use Lareon\Modules\Gadget\App\Logic\GadgetLogic;
use Teksite\Lareon\Facade\JsonResponse;

class GadgetsController extends Controller
{
    public function __construct(public GadgetLogic $logic)
    {
    }

    public function load(LoadGadgetApiRequest $request)
    {
        $res=$this->logic->load($request->validated());

        return JsonResponse::byResult($res)->reply();
   }
}
