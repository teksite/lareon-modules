<?php

namespace Lareon\Modules\Comment\App\Http\Controllers\Web\Admin;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Comment\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Comment\App\Http\Requests\Admin\NewCommentRequest;
use Lareon\Modules\Comment\App\Http\Requests\Admin\UpdateCommentRequest;
use Lareon\Modules\Comment\App\Logic\CommentsLogic;
use Lareon\Modules\Comment\App\Models\Comment;
use Teksite\Lareon\Facade\WebResponse;

class CommentsController extends Controller implements HasMiddleware
{
    public function __construct(public CommentsLogic $logic)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.comment.read'),
            new Middleware('can:admin.comment.create', only: ['create', 'store']),
            new Middleware('can:admin.comment.edit', only: ['edit', 'update']),
            new Middleware('can:admin.comment.delete', only: ['destroy']),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = $this->logic->get()->result;
        $count = $this->logic->trashCount()->result;
        return view('comment::admin.pages.comments.index', compact('comments' ,'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
           'comment' => 'required|numeric|exists:comments,id',
        ]);
        $parentComment=Comment::find($request->get('comment'));
        return view('comment::admin.pages.comments.create' ,compact('parentComment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewCommentRequest $request)
    {
        $res = $this->logic->replyTo($request->validated());
        return WebResponse::byResult($res ,route('admin.comments.index'))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return redirect($comment->path());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return view('comment::admin.pages.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $res = $this->logic->change($request->validated(), $comment);
        return WebResponse::byResult($res, route('admin.comments.edit', $comment))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $res = $this->logic->delete($comment);
        return WebResponse::byResult($res, route('admin.comments.index'))->go();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroyMany(Request $request)
    {
        $validated=$request->validate([
            'type'=>'required|string',
        ]);

        $res = $this->logic->deleteMany($validated);
        return WebResponse::byResult($res, route('admin.comments.index'))->go();
    }

}
