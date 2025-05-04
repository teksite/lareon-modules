<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('gadgets')]))
    @section('description', __('gadgets are customizable contents or functionality to different parts of the application'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.appearance.gadgets.create')" :title="__('create a new one')" color="create"
                                    can="admin.gadget.create"/>
        <x-lareon::link.trash :count="$count" :href="route('admin.appearance.gadgets.trash.index')"
                              :title="__('trash :title',['title'=>__('gadgets')])" color="create"
                              can="admin.gadget.create"/>
    @endsection
    @section('list')

        @if(count($gadgets))
            <ul class="grid gap-6 md:grid-cols-2 lg:grid-cols-4" >
            @foreach($gadgets as $key=>$gadget)
                <li>
                    <x-lareon::box class="group">
                        <h3 class="text-center">{{$gadget->title}}</h3>
                        <div class="text-center">{{$gadget->label}}</div>
                            <div class="mt-6 action flex items-center gap-3 justify-center invisible group-hover:visible">
                                <x-lareon::link.edit :href="route('admin.appearance.gadgets.edit' , $gadget)" can="admin.gadget.edit"/>
                                <x-lareon::link.delete :href="route('admin.appearance.gadgets.destroy' , $gadget)" can="admin.gadget.delete"/>
                            </div>
                    </x-lareon::box>
                </li>
            @endforeach
            </ul>
        @else
            <div>
                <p class="text-center">
                    {{__('no item has been found')}}.
                </p>
            </div>
        @endif
        {{$gadgets->appends($_GET)->links()}}
    @endsection

</x-lareon::admin-list-layout>
