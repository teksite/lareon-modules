<x-lareon::admin-editor-layout type="update"  :instance="$menu">
    @section('title', __('edit the :title',['title'=>__('menu'). " ($menu->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('menu') . " ($menu->title)"]))
    @section('formRoute', route('admin.appearance.menus.update', $menu))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.appearance.menus.index')" :title="__('all :title',['title'=>__('menus')])" color="index"/>
    @endsection
    @section('header.end')
        @parent
        <x-lareon::link.delete :href="route('admin.appearance.menus.destroy', $menu)" can="admin.menu.delete"/>
    @endsection
    @section('form')
        <x-lareon::box>
            <x-lareon::sections.text :value="$menu->title" :title="__('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
            <x-lareon::sections.text :disabled="true" readonly :value="$menu->label" :title="__('label')" name="label"/>
            <x-lareon::sections.text :value="$menu->classes" :title="__('classes')" name="classes" :placeholder="__('write :title',['title'=>__('classes')])" :required="false"/>

        </x-lareon::box>
    @endsection
</x-lareon::admin-editor-layout>
