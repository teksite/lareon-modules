<x-lareon::admin-editor-layout type="update"  :instance="$gadget">
    @section('title', __('edit the :title',['title'=>__('gadget') . " ($gadget->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('gadget') . " ($gadget->title)"]))

    @section('formRoute', route('admin.appearance.gadgets.update', $gadget))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.appearance.gadgets.index')" :title="__('all :title',['title'=>__('gadgets')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.appearance.gadgets.create')" :title="__('new :title',['title'=>__('gadgets')])" color="create" can="admin.gadget.create"/>
    @endsection
    @section('header.end')
        @parent
            <x-lareon::link.delete :href="route('admin.appearance.gadgets.destroy', $gadget)" can="admin.gadget.delete"/>
    @endsection
    @section('form')
        <x-lareon::sections.title :value="old('title') ?? $gadget->title" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" :required="false" rows="15" :open="true">{{old('body') ?? $gadget->body}}</x-lareon::sections.editor>

    @endsection
    @section('aside')
        <x-lareon::sections.template :value="old('template') ?? $gadget->template" :accordion="true" path="gadgets"/>
    @endsection
</x-lareon::admin-editor-layout>
