<x-lareon::admin-trash-layout :trash="route('admin.questionnaire.inboxes.trash.index')" :index="route('admin.questionnaire.inboxes.index')" title="{{__('inboxes')}}">
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','form_id'=>__('form'),'created_at'=>__('created at'),'deleted_at'=>__('deleted at'),]">
                @if(count($inboxes))
                @foreach($inboxes as $key=>$inbox)
                    <tr>
                        <td class="p-3">{{$inboxes->firstItem() + $key}}</td>
                        <td>{{$inbox->form->title}}</td>
                        <td>{{$inbox->created_at}}</td>
                        <td>{{$inbox->deleted_at}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.restore :href="route('admin.pages.trash.reinstate' , $inbox->id)" can="admin.page.edit"/>
                                <x-lareon::link.delete :href="route('admin.pages.trash.prune' , $inbox->id)" can="admin.page.trash"/>
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
            {{$inboxes->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
