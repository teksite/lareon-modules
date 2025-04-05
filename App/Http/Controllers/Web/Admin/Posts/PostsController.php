<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Posts;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Blog\App\Http\Requests\Admin\NewPostRequest;
use Lareon\Modules\Blog\App\Http\Requests\Admin\UpdatePostRequest;
use Lareon\Modules\Blog\App\Logic\PostLogic;
use Lareon\Modules\Blog\App\Models\Post;
use Teksite\Lareon\Facade\WebResponse;

class PostsController extends Controller implements HasMiddleware
{
    public function __construct(public PostLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.blog.post.read'),
            new Middleware('can:admin.blog.post.create', only: ['create', 'store']),
            new Middleware('can:admin.blog.post.edit', only: ['edit', 'update']),
            new Middleware('can:admin.blog.post.delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->logic->get()->result;
        $count = $this->logic->trashCount()->result;

        return view('blog::admin.pages.posts.index', compact('posts' ,'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog::admin.pages.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewPostRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res ,route('admin.blog.posts.edit', $res->result))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return redirect($post->path());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('blog::admin.pages.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $res = $this->logic->change($request->validated(), $post);
        return WebResponse::byResult($res, route('admin.blog.posts.edit', $post))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $res = $this->logic->delete($post);
        return WebResponse::byResult($res, route('admin.blog.posts.index'))->go();
    }
}
