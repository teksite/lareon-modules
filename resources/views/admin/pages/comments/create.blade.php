<x-lareon::admin-editor-layout>
    @section('title', __('reply to the comment'))
    @section('description', __('in this window you can to the comment'))
    @section('formRoute', route('admin.comments.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.comments.index')" :title="__('all :title',['title'=>__('comments')])" color="index"/>
    @endsection
    @section('form')
        <div class="p-3 rounded-lg border border-slate-300">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    @if(!$parentComment->confirmed)
                        <div class="flex items-center gap-3">
                    <span class="relative flex size-3">
                     <span
                         class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-600 opacity-75"></span>
                     <span class="relative inline-flex size-3 rounded-full bg-red-900"></span>
                </span>
                            <p class="text-red-600">
                                {{__('this comment hasn\'t been approved yet, so your reply won\'t be visible to users on the related page')}}
                                .
                            </p>
                        </div>
                        <hr class="my-3">
                    @endif
                    <div>
                        {{$parentComment->message}}
                    </div>
                </div>
                <div class="p-3 rounded-lg border border-slate-300">
                    <ul class="text-sm space-y-3">
                        <li class="flex items-center gap-3 justify-between">
                            <span>{{__('created at')}}</span>
                            <span dir="ltr">{{__(dateAdapter($parentComment->created_at))}}</span>
                        </li>
                        <li class="flex items-center gap-3 justify-between">
                            <span>{{__('confirmed')}}</span>
                            <span dir="ltr">{{$parentComment->confirmed ? '✔' : '❗'}}</span>
                        </li>
                        <li class="flex items-center gap-3 justify-between">
                            <span>{{__('author')}}</span>
                            <span>
                             @if($parentComment->user_id)
                                    @if($parentComment->user?->path())
                                        <a href="{{$parentComment->user?->path()}}" target="_blank">
                                        <i class="tkicon fill-none stroke-green-600" size="16" data-icon="eye"></i>
                                    </a>
                                    @else
                                        <span title="{{__('user')}}">✔</span>
                                    @endif
                                @endif
                                {{$parentComment->name}}
                         </span>
                        </li>
                        <li class="flex items-center gap-3 justify-between">
                            <span>{{__('email')}}</span>
                            <span dir="ltr">{{$parentComment->email}}</span>
                        </li>
                        <li class="flex items-center gap-3 justify-between">
                            <span>{{__('ip')}}</span>
                            <span dir="ltr">{{$parentComment->ip_address}}</span>
                        </li>
                        <li class="flex items-center gap-3 justify-between">
                            <span>{{__('page')}}</span>
                            <span dir="ltr">
                               <a href="{{$parentComment->path()}}" target="_blank">{{$parentComment->title}}</a>
                         </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <input type="hidden" name="parent_id" value="{{$parentComment->id}}">
        <x-lareon::sections.editor :accordion="false" :title="__('reply')" name="message" :placeholder="__('write a :title' ,['title'=>__('reply')])" :required="true" rows="6">{{old('message')}}</x-lareon::sections.editor>
    @endsection
    @section('form.after')
        <x-comment::sections.bloodline :comment="$parentComment" />
    @endsection

</x-lareon::admin-editor-layout>
