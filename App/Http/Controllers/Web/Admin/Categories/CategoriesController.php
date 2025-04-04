<?php

namespace Lareon\Modules\Blog\App\Http\Controllers\Web\Admin\Categories;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\CMS\App\Logic\UserMetaLogic;
use Lareon\Modules\Blog\App\Http\Requests\Admin\NewCategoryRequest;
use Lareon\Modules\Blog\App\Http\Requests\Admin\UpdateCategoryRequest;
use Lareon\Modules\Blog\App\Logic\CategoryLogic;
use Lareon\Modules\Blog\App\Models\Category;
use Lareon\Modules\Blog\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Lareon\Facade\WebResponse;

class CategoriesController extends Controller implements HasMiddleware
{

    public function __construct(public CategoryLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.blog.category.read'),
            new Middleware('can:admin.blog.category.create', only: ['create', 'store']),
            new Middleware('can:admin.blog.category.edit', only: ['edit', 'update']),
            new Middleware('can:admin.blog.category.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $categories = $this->logic->get()->result;
        return view('blog::admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->logic->getTree()->result;
        return view('blog::admin.pages.categories.create', compact('categories'));
    }


    public function store(NewCategoryRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res, route('admin.blog.categories.edit',$res->result))->go();
    }

    public function show(Category $category)
    {
        if ($category->path()) return redirect()->route('blog.categories.show', $category);
        abort(404);
    }

    public function edit(Category $category)
    {
        $categories = $this->logic->getTree()->result;
        return view('blog::admin.pages.categories.edit', compact('category', 'categories'));

    }

    public function update(UpdateCategoryRequest $request , Category $category)
    {

        $result = $this->logic->change($request->validated(), $category);
        return WebResponse::byResult($result, route('admin.blog.categories.edit',$category))->go();
    }


    public function destroy(Category $category)
    {
        $result = $this->logic->delete($category);
        return WebResponse::byResult($result, route('admin.blog.categories.index'))->go();
    }
}
