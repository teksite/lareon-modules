<x-lareon::admin-editor-layout type="update"  :instance="$comment">
    @section('title', __('edit the :title',['title'=>__('comment')]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('comment')]))

    @section('formRoute', route('admin.comments.update', $comment))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.comments.index')" :title="__('all :title',['title'=>__('comments')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.comments.create' ,['comment'=>$comment->id])" :title="__('reply')" color="create" can="admin.comment.create"/>
    @endsection
    @section('header.end')
        @parent
        <x-lareon::link.delete :href="route('admin.comments.destroy', $comment)" can="admin.comment.delete"/>
    @endsection
    @section('form')
        <div>
            {{$comment->message}}
        </div>
        <x-lareon::sections.radio classBox="flex items-center gap-3" name="confirmed" :title="__('conformation')" :items="[['title'=>__('confirmed') ,'value'=>1], ['title'=>__('unconfirmed') ,'value'=>0]]" :checked="$comment->confirmed"/>
        <input type="hidden" name="parent_id" value="{{$comment->id}}">
        <x-lareon::sections.editor :accordion="false" :title="__('message')" name="message" :placeholder="__('message')" :required="true" rows="6">{{old('message') ?? $comment->message }}</x-lareon::sections.editor>
    @endsection
    @section('aside')
       <x-lareon::accordion.box :title="__('information')">
           <ul class="space-y-3">
               <li class="flex items-center gap-3 justify-between">
                   <span>{{__('author')}}</span>
                   <span>
                    @if($comment->user_id)
                           @if($comment->user?->path())
                               <a href="{{$comment->user?->path()}}" target="_blank">
                        <i class="tkicon fill-none stroke-green-600" size="16" data-icon="eye"></i>
                     </a>
                           @else
                               <span title="{{__('user')}}">✔</span>
                           @endif
                       @endif
                       {{$comment->name}}
             </span>
               </li>
               <li class="flex items-center gap-3 justify-between">
                   <span>{{__('email')}}</span>
                   <span>{{$comment->email}}</span>
               </li>
               <li class="flex items-center gap-3 justify-between">
                   <span>{{__('ip')}}</span>
                   <span dir="ltr">{{$comment->ip_address}}</span>
               </li>
               <li class="flex items-center gap-3 justify-between">
                   <span>{{__('page')}}</span>
                   <span dir="ltr"><a href="{{$comment->path()}}" target="_blank">{{$comment->title}}</a></span>
               </li>
           </ul>
       </x-lareon::accordion.box>
    @endsection
    @section('form.after')
        <x-comment::sections.bloodline :comment="$comment" />
    @endsection
</x-lareon::admin-editor-layout>
