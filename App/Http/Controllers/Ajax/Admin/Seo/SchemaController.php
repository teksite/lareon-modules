<?php

namespace Lareon\Modules\Seo\App\Http\Controllers\Ajax\Admin\Seo;

use Lareon\Modules\Seo\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Seo\App\Http\Requests\Admin\GetSchemaContentRequest;
use Lareon\Modules\Seo\App\Logic\SchemaLogic;
use Teksite\Lareon\Facade\JsonResponse;

class SchemaController extends Controller
{
    public function __construct(public SchemaLogic $logic)
    {
    }

    public function get_model(GetSchemaContentRequest $request)
    {
        $result = $this->logic->getView($request->validated());
        return JsonResponse::response()->byResult($result)->reply();

    }
}
