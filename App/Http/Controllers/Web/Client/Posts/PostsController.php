<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Client\Posts;

use Illuminate\Support\Facades\View;
use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Blog\App\Models\Post;
use Lareon\Modules\Seo\App\Logic\SeoGeneratorLogic;

class PostsController extends Controller
{
    public function __construct(public SeoGeneratorLogic $seo)
    {
    }

    public function index()
    {
        //TODO change it Blog:SEO

        $seo =$this->seo->generate(null ,
            [
                'title'=>'111111111111' ,
                'featured_image'=>'22222222' ,
                'meta'=>[
                    'title'=>'3333333' ,
                    'featured_image'=>'444444444444' ,
                    'indexable'=>'index',
                    'follow'=>'nofollow',
                    'description'=>'55555555555555555555' ,
                    'conical_url'=>'6666666666666'
                ],
                'schema'=>[
                    'seo_type'=>'Article',
                ]
            ])->result;
        dd($seo);
    }

    public function show(Post $post)
    {
        $seo =$this->seo->generate($post)->result;
        return View::first(['pages.posts.template.'.$post->template , 'pages.posts.show'] ,compact('post' , 'seo'));
    }
}
