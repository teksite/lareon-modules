<?php

namespace Lareon\Modules\Comment\App\Http\Controllers\Ajax\Client\Comments;

use Lareon\Modules\Comment\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Comment\App\Http\Requests\LoadMoreCommentApiRequest;
use Lareon\Modules\Comment\App\Http\Requests\NewCommentApiRequest;
use Lareon\Modules\Comment\App\Logic\CommentsLogic;
use Teksite\Lareon\Facade\JsonResponse;

class CommentsController extends Controller
{
    public function __construct(public CommentsLogic $logic)
    {
    }

    public function store(NewCommentApiRequest $request)
    {
        $result = $this->logic->reply($request->validated());
        return JsonResponse::byResult($result)->reply();
    }

    public function load(LoadMoreCommentApiRequest $request)
    {
        $result = $this->logic->loadMoreCommentByAjax($request->validated());
        return JsonResponse::byResult($result)->reply();
    }
}
