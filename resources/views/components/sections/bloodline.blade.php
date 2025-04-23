@props(['comment'])
<h3>
    {{__('bloodline')}}
</h3>
<hr class="my-3 border-slate-300">
<ul class="space-y-3">
    @foreach($comment->bloodline()->get() as $cmnt)
        <li>
            <div class="flex items-center gap-3">
               @if($cmnt->id !=$comment->id)
                    <x-lareon::link.reply :href="route('admin.comments.edit' , $cmnt)" can="admin.comment.create" title="{{__('reply')}}"/>
                @else
                   <span class="ms-6"></span>
               @endif

                <span dir="ltr">{{$cmnt->confirmed ? '✔' : '❗'}}</span>
                <div>
                    {{$cmnt->message}}
                </div>
            </div>
        </li>
    @endforeach
</ul>
