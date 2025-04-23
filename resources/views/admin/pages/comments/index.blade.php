<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('comments')]))
    @section('description', __('comments are user-submitted messages or feedbacks, to share thoughts, ask questions, or interaction with others'))
    @section('header.start')
        <x-lareon::link.trash :count="$count" :href="route('admin.comments.trash.index')"
                              :title="__('trash :title',['title'=>__('comments')])" color="create"
                              can="admin.comment.create"/>
    @endsection
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','confirmed'=>__('confirmed'),'created_at'=>__('created at'),]">
                @if(count($comments))
                    @foreach($comments as $key=>$comment)
                        <tr>
                            <td class="p-3 w-6">
                                <div class="flex items-center gap-1">
                                    <x-lareon::sections.checkDelete :id="$comment->id"/>
                                    {{$comments->firstItem() + $key}}
                                </div>
                            </td>
                            <td colspan="2">
                                <div class="">
                                    <div class="flex gap-3 items-start justify-between bg-zinc-100">
                                        <div class="flex gap-3">
                                            <x-lareon::link.show :href="$comment->path()"/>
                                            {{$comment->title}}
                                        </div>
                                        <div class="flex items-center gap-3">

                                            <span>
                                                <i class="tkicon fill-none {{$comment->confirmed ? 'stroke-green-600': 'stroke-yellow-600'}}"
                                                   data-icon="{{$comment->confirmed ? 'tick': 'exclamation'}}"
                                                   stroke-width="4" size="16"></i>
                                            </span>
                                            <span class="text-sm">
                                                {{$comment->name}}
                                            </span>
                                            <span class="text-sm" dir="ltr">
                                           {{$comment->created_at}}
                                             </span>
                                        </div>
                                    </div>
                                    <div style="text-overflow: ellipsis; white-space: nowrap;">
                                        {{$comment->message}}
                                    </div>
                                </div>

                                <div class="action">
                                    <x-lareon::link.reply
                                        :href="route('admin.comments.create' , ['comment'=>$comment->id])" can="admin.comment.create"/>
                                    <x-lareon::link.edit :href="route('admin.comments.edit' , $comment)" can="admin.comment.edit"/>
                                    <x-lareon::link.delete :href="route('admin.comments.destroy' , $comment)" can="admin.comment.delete"/>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <p class="text-center">
                                {{__('no item has been found')}}.
                            </p>
                        </td>
                    </tr>
                @endif
            </x-lareon::table>
            {{$comments->appends($_GET)->links()}}

            <div class="mt-6">
                <div class="flex items-center gap-3">
                    <x-lareon::input.label :title="__('delete')" for="deleteManyForm"/>
                    <form action="{{route('admin.comments.delete.items')}}" method="POST" id="deleteManyForm" class="deltfrmItms">
                        @csrf
                        @method('DELETE')
                        <div class="flex items-center gap-1">
                            <x-lareon::input.select name="type">
                                <option id="deleteManyForm_choose" selected disabled>{{__('choose')}}</option>
                                <option id="deleteManyForm_unconfirmed" value="unconfirmed">{{__('unconfirmed')}}</option>
                                <option id="deleteManyForm_selected" value="">{{__('selected')}}</option>
                                <option id="deleteManyForm_all" value="all">{{__('all')}}</option>
                            </x-lareon::input.select>
                            <x-lareon::button.outline type="submit" class="min-w-fit" color="danger">{{__('do it')}}</x-lareon::button.outline>
                        </div>
                    </form>
                </div>
            </div>
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
