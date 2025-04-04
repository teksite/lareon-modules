<?php

namespace Lareon\Modules\Blog\App\Logic;

use Illuminate\Support\Arr;
use Lareon\Modules\Blog\App\Models\Category;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class CategoryLogic
{
    public function get()
    {
        return app(ServiceWrapper::class)(function () {
            return app(FetchDataService::class)(function () {
                $categories = Category::query();
                if ($keyword = request()->get('s')) {
                    $categories->where('title', 'LIKE', "%$keyword%");
                } else {
                    $categories = $categories->where('parent_id', 0);
                }
                return $categories->paginate(20);
            });
        });
    }

    public function getTree()
    {
        return app(ServiceWrapper::class)(function () {

            return Category::query()->where('parent_id',0)->get()
                ->map(function ($category) {
                    return $category->descendantsAndSelf()->orderBy('title')->get();
                })->flatten();
        });

    }

    public function register(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            return Category::query()->create(Arr::except($inputs ,['seo']));
        });
    }

    public function change(array $inputs, Category $category)
    {
        return app(ServiceWrapper::class)(fn() => $category->update($inputs));
    }

    public function delete(Category $category)
    {
        return app(ServiceWrapper::class)(function () use ($category) {
            if ($category->children) {
                foreach ($category->children as $child) {
                    $child->update([
                        'parent_id' => $category->parent_id ?? 0
                    ]);
                }
            }
            $relatedPosts = $category->posts();
            $relatedPosts->get()->map(function ($post) {
                $post->categories()->sync(1);
            });

            $category->delete();
        });
    }
}

