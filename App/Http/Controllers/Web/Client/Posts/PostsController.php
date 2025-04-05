<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Client\Posts;

use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Blog\App\Models\Post;
use Lareon\Modules\Seo\App\Logic\SchemaLogic;

class PostsController extends Controller
{
    public function __construct(public SchemaLogic $logic)
    {
    }

    public function index()
    {

    }

    public function show(Post $post)
    {
        dd($this->logic->generate($post));
    }
}
