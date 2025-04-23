@props(['comments'=>[] ,'model' ,'parentId'=>null])

<ul class="space-y-6">
    @foreach($comments as $comment)
        <li>
            <x-comment::client.item :comment="$comment" :parentId="$loop->depth > 2 ? $parentId : $comment->id"/>
            @if(count($comment->children))
                <div class="mt-3">
                    <x-comment::client.sub :comments="$comment->children" :model="$model" :parentId="$comment->id"/>
                </div>
            @endif
        </li>
    @endforeach
</ul>
