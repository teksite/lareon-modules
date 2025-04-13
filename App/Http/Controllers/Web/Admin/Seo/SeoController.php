<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Seo;

use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeoController extends Controller
{

    public function edit()
    {
        return view('blog::admin.pages.seo.edit');

    }
    public function update(Request $request)
    {
        dd($request->all());
        return view('blog::admin.pages.seo.edit');
    }
}
