<x-lareon::admin-entry-layout>
    @section('title', __(':title list',['title'=>__('menus')]))
    @section('formRoute', route('admin.appearance.menus.store'))
    @section('description', __('menus help visitors easily navigate between different pages or sections'))
    @can('admin.menu.create')
        @section('form')
            <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique :title' ,['title'=>__('title')])" :required="true"/>
        @endsection
    @endcan
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title') ,'label'=>__('label') ,]">
                @foreach($menus as $key=>$menu)
                    <tr>
                        <td class="p-3">{{$menus->firstItem() + $key}}</td>
                        <td>{{$menu->title}}</td>
                        <td>{{$menu->label}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.sub :href="route('admin.appearance.menus.sub.index' , $menu)" can="admin.menu.read"/>
                                <x-lareon::link.edit :href="route('admin.appearance.menus.edit' , $menu)" can="admin.menu.edit"/>
                                <x-lareon::link.delete :href="route('admin.appearance.menus.destroy' , $menu)" can="admin.menu.delete"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-lareon::table>
            {{$menus->appends($_GET)->links()}}

        </x-lareon::box>
    @endsection

</x-lareon::admin-entry-layout>
