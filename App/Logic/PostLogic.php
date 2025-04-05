<?php

namespace Lareon\Modules\Blog\App\Logic;

use Illuminate\Support\Arr;
use Lareon\Modules\Blog\App\Models\Post;
use Lareon\Modules\Seo\App\Events\CreateOrUpdateInstanceEvent;
use Lareon\Modules\Seo\App\Models\SeoSitemap;
use Teksite\Extralaravel\Traits\TrashMethods;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class PostLogic
{
    use TrashMethods;

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Post::class, ['title'], ...$fetchData);
        });
    }

    public function register(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $post = Post::query()->create(Arr::except($inputs, ['tag', 'meta', 'seo']));
            $post->categories()->attach($inputs['categories']);
            $post->assignTags($inputs['tags'] ?? null);

            event(new CreateOrUpdateInstanceEvent($post ,$inputs));

            return $post;
        });
    }

    public function change(array $inputs, Post $post)
    {

        return app(ServiceWrapper::class)(function () use ($inputs, $post) {
            $post->update(Arr::except($inputs, ['tag', 'meta', 'seo']));
            $post->categories()->sync($inputs['categories']);
            $post->assignTags($inputs['tags'] ?? null);

            event(new CreateOrUpdateInstanceEvent($post ,$inputs));
            return $post;
        });
    }

    public function delete(Post $post)
    {
        return app(ServiceWrapper::class)(function () use ($post) {

            event(new CreateOrUpdateInstanceEvent($post));
            $post->delete();

        });
    }

    protected function getModelClass(): string
    {
        return Post::class;
    }


}

