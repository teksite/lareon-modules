<?php

namespace Lareon\Modules\Comment\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Lareon\Modules\Comment\App\Events\NewCommentEvent;
use Lareon\Modules\Comment\App\Models\Comment;
use Teksite\Extralaravel\Traits\TrashMethods;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class CommentsLogic
{
    use TrashMethods;

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Comment::class, ['confirmed', 'created_at', 'name', 'email', 'message'], ...$fetchData);
        });
    }


    public function reply(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $data = [
                'model_type' => $inputs['data_info']['type'] ?? null,
                'model_id' => $inputs['data_info']['identify'] ?? null,
                'message' => $inputs['message'] ?? null,
                'name' => $inputs['name'] ?? auth()->user()->nick_name ?? auth()->user()->name,
                'email' => $inputs['email'] ?? auth()->user()->email,
                'user_id' => auth()->check() ? auth()->id() : null,
                'ip_address' => request()->ip(),
                'parent_id' => $inputs['parent'] ?? null,
            ];
            $comment = Comment::query()->create($data);
            event(new NewCommentEvent($comment));
            return $comment;
        });
    }

    public function replyTo(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $parent = Comment::query()->find($inputs['parent_id']);
            $parent->update([
                'confirmed' => true,
            ]);
            $author = auth()->user();
            return Comment::query()->create([
                'parent_id' => $inputs['parent_id'],
                'model_type' => $parent->model_type,
                'model_id' => $parent->model_id,
                'message' => $inputs['message'],
                'confirmed' => true,
                'name' => $author->nickname ?? $author->name,
                'email' => $author->email,
                'user_id' => $author->id,
                'ip_address' => request()->ip(),
            ]);
        });
    }

    public function change(array $inputs, Comment $comment)
    {
        return app(ServiceWrapper::class)(fn() => $comment->update($inputs));
    }

    public function delete(Comment $comment)
    {
        return app(ServiceWrapper::class)(function () use ($comment) {
            $comment->descendantsAndSelf()->get()->each(function ($item) {
                $item->delete();
            });
        });
    }

    public function deleteMany(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $items = explode(',', $inputs['type']);
            switch (true) {
                case in_array('all', $items):
                    Comment::query()->delete();
                    break;
                case in_array('unconfirmed', $items):
                    Comment::query()->where('confirmed', null)->orWhere('confirmed', 0)->delete();
                    break;
                default:
                    Comment::whereIn('id', $items)->get()->each(function ($comment) {
                        $comment->descendantsAndSelf()->get()->each(function ($item) {
                            $item->delete();
                        });
                    });
            }
        });
    }

    public function loadMoreCommentByAjax(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $offset = (integer)$inputs['offset'];
            $limit = config('lareon.comment.limit', 5);
            $model = $inputs['bind'];
            $id = $inputs['identify'];

            $comments = Comment::query()
                ->where('model_id', $id)
                ->where('model_type', $model)
                ->whereNull('parent_id')
                ->where('confirmed', true)
                ->with(['children' => function ($query) {
                    $query->where('confirmed', true)->with(['children' => function ($query) {
                        $query->where('confirmed', true)->with(['children' => function ($query) {
                            $query->where('confirmed', true);
                        }]);
                    }]);
                }])
                ->offset($limit * $offset)->limit($limit)
                ->get();
            return view('components.comment.confirmed', compact('comments', 'model'))->render();

        });

    }

    protected function getModelClass(): string
    {
        return Comment::class;
    }
}

