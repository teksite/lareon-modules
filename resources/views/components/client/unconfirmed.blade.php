@props(['comments'=>[]])
@if(count($comments))
    <div class="unconfined_comments mb-6">
        <div class="flex items-center">
            <h3 class="text-gray-400">
                {{__('pending comments')}}
            </h3>
            <span class="text-gray-400">
            ...
        </span>
        </div>
        <ul class="space-y-1 text-zinc-400">
            @foreach($comments as $comment)
                <li class="border border-slate-200 rounded-lg px-3 py-1">
                    <div class="mb-3 flex items-start justify-between gap-6">
                        <div>
                            <span class="text-xs font-semibold" dir="ltr">{{dateAdapter($comment->created_at)}}</span>
                        </div>
                    </div>
                    <div class="">
                        <p>
                            {{$comment->message}}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
