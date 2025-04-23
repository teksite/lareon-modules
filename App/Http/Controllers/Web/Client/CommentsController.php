<?php

namespace Lareon\Modules\Comment\App\Http\Controllers\Web\Client;

use Lareon\Modules\Comment\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Comment\App\Http\Requests\NewCommentRequest;
use Lareon\Modules\Comment\App\Logic\CommentsLogic;
use Teksite\Lareon\Facade\WebResponse;

class CommentsController extends Controller
{
    public function __construct(public CommentsLogic $logic)
    {
    }

    public function store(NewCommentRequest $request): WebResponse
    {
        $result = $this->logic->reply($request->validated());
        return WebResponse::byResult($result)->go();
    }

}
