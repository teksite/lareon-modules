<x-lareon::admin-trash-layout :trash="route('admin.comments.trash.index')" :index="route('admin.comments.index')" title="{{__('comments')}}">
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','confirmed'=>__('confirmed'),__('title'),'created_at'=>__('created at'),'deleted_at'=>__('deleted at') ,__('author'),]">
                @if(count($comments))
                @foreach($comments as $key=>$comment)
                    <tr>
                        <td class="p-3">{{$comments->firstItem() + $key}}</td>
                        <td class="p-3">
                            <i class="tkicon fill-none {{$comment->confirmed ? 'stroke-green-600': 'stroke-yellow-600'}}" data-icon="{{$comment->confirmed ? 'tick': 'exclamation'}}" stroke-width="4" size="16"></i>
                        </td>
                        <td class="p-3">
                            <div class="flex gap-3">
                                <x-lareon::link.show :href="$comment->path()"/>
                                {{$comment->title}}
                            </div>
                        </td>
                        <td class="p-3">
                            {{$comment->created_at}}
                        </td>
                        <td class="p-3">
                            {{$comment->deleted_at}}
                        </td>
                        <td class="p-3">
                            {{$comment->name}}
                        </td>
                        <td>
                            <div class="action">
                                <x-lareon::link.restore :href="route('admin.comments.trash.reinstate' , $comment->id)" can="admin.comment.edit"/>
                                <x-lareon::link.delete :href="route('admin.comments.trash.prune' , $comment->id)" can="admin.comment.trash"/>
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
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
