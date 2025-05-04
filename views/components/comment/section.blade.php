@props(['model','offset'=>0 ,'limit'=>config('lareon.comment.limit')])
@php
    $comments=\Lareon\Modules\Comment\App\Models\Comment::query()
        ->where('model_id', $model->id)
        ->where('model_type', get_class($model))
        ->whereNull('parent_id')
        ->where('confirmed' ,true)
        ->with(['children' => function ($query) {
            $query->where('confirmed', true)->with(['children' => function ($query) {
                $query->where('confirmed', true)->with(['children' => function ($query) {
                    $query->where('confirmed', true);
                }]);
            }]);
        }])
        ->offset($offset)->limit($limit)
        ->get();
    $unconfirmed=\Lareon\Modules\Comment\App\Models\Comment::query()
        ->where('model_id', $model->id)
        ->where('model_type', get_class($model))
        ->where('confirmed' ,false)
        ->get();
@endphp
<section id="comment-sec">
    <h2 class="mb-6">
        {{__('comments')}}
    </h2>
    @if(config('lareon.comment.unconfirmed_visibility'))
        <x-comment.unconfirmed :comments="$unconfirmed" :model="$model"/>
    @endif
    <div>
        <x-comment.new :model="$model"/>
        <hr class="border-slate-200 mx-auto my-6 w-11/12">
        <ul class="space-y-6" id="listComment">
            <x-comment.confirmed :comments="$comments ?? []" :model="$model"/>
        </ul>
        <x-comment.reply :model="$model" id="comment_modal"/>
        <x-comment.more :model="$model" :offset="$offset" :limit="$limit" id="comment_modal"/>
    </div>
</section>
