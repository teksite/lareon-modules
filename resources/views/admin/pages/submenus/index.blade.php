<x-lareon::admin-entry-layout>
    @push('headerScripts')
        @vite(['Lareon/Modules/Menu/resources/js/app.js','Lareon/Modules/Menu/resources/css/app.css'])
    @endpush
    @section('title', __(':title list',['title'=>__('menus')]))
    @section('formRoute', route('admin.appearance.menus.sub.store', $menu))
    @section('description', __('menus help visitors easily navigate between different pages or sections'))
    @can('admin.menu.create')
        @section('form')
            <x-lareon::sections.text :title="__('title')" name="title" id="newTitle"
                                     :placeholder="__('enter a :title' ,['title'=>__('title')])"/>
            <x-lareon::sections.text :title="__('url')" name="url" id="newUrl"
                                     :placeholder="__('enter a :title' ,['title'=>__('url')])"/>
        @endsection
    @endcan
    @section('list')
        <form action="{{route('admin.appearance.menus.sub.update',$menu)}}" method="POST">
            @csrf
            @method('PATCH')
            <fieldset class="fieldset">
                <legend class="legend">
                    {{__('items')}}
                </legend>
                @csrf

                <div id="nestedMenus" class="list-group nested-sortable">
                    <x-menu::sections.menu-item :items="$items"/>
                    <div class="list-group-item h-1" >
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end">
                    <x-lareon::button.solid color="update">
                        {{__('update')}}
                    </x-lareon::button.solid>
                </div>
            </fieldset>
        </form>
    @endsection

</x-lareon::admin-entry-layout>
