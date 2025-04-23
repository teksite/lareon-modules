@props(['comment', 'parentId'=>null])
@php($rand='comment_itr'.rand(1000,9999))

<div id="{{$rand}}" class="p-3 border border-slate-200 rounded-lg">
    <div class="flex items-start justify-between gap-6">
        <figure class="flex items-center gap-3">
            <img src="{{asset('storage/uploads/admin/avatar-default.jpg')}}" alt="{{$comment->name}}"
                 width="45" height="45" class="rounded-full border border-gray-600 comment_avatar">
            <figcaption
                class="comment_author font-bold">{{$comment->name}}</figcaption>
        </figure>
        <div>
            <span class="text-xs font-semibold" dir="ltr">{{dateAdapter($comment->created_at)}}</span>
        </div>
    </div>
    <div class="md:ms-16">
        <p class="comment_message">
            {{$comment->message}}
        </p>
    </div>
    <div class="flex justify-end">
        <x-lareon::button.outline color="blue" class="flex items-center gap-1 reply_comment_btn text-sm"
                          data-comment="{{$parentId}}" data-iteration="{{$rand}}"
                          x-data="" x-on:click.prevent="$dispatch('open-modal', 'reply-comment')">
            <i class='tkicon stroke-blue-600 fill-blue-600 ' data-icon='reply' stroke-width="1.5" size='14'></i>
            {{__('reply')}}
        </x-lareon::button.outline>
    </div>
</div>
