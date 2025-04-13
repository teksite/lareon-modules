<x-lareon::admin-trash-layout :trash="route('admin.pages.trash.index')" :index="route('admin.pages.index')" title="{{__('pages')}}">
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title'),]">
                @if(count($pages))
                @foreach($pages as $key=>$page)
                    <tr>
                        <td class="p-3">{{$pages->firstItem() + $key}}</td>
                        <td>{{$page->title}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.restore :href="route('admin.pages.trash.reinstate' , $page->id)" can="admin.page.edit"/>
                                <x-lareon::link.delete :href="route('admin.pages.trash.prune' , $page->id)" can="admin.page.trash"/>
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
            {{$pages->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
