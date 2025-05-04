@props(['comments'=>[] ,'model' ,'parentId'=>null])

@foreach($comments as $comment)
    <li class="{{$loop->depth > 2 ? '': 'border border-slate-300 rounded-lg'}}">
        <x-comment.item :comment="$comment" :parentId="$comment->id"/>
        @if(count($comment->children))
            <div class="mt-5 mb-3 ms-3">
                <x-comment.accordion >
                    <x-comment.sub :comments="$comment->children" :model="$model" :parentId="$comment->id"/>
                </x-comment.accordion>
            </div>
        @endif
    </li>
@endforeach
