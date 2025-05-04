<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('gadget')]))
    @section('description', __('in this window you can create a new :title',['title'=>__('gadget')]))
    @section('formRoute', route('admin.appearance.gadgets.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.appearance.gadgets.index')" :title="__('all :title',['title'=>__('gadgets')])" color="index"/>
    @endsection
    @section('form')
        <x-lareon::sections.title :value="old('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" :required="false" rows="15" :open="true">{{old('body')}}</x-lareon::sections.editor>
    @endsection
    @section('aside')
        <x-lareon::sections.template :value="old('template')" :accordion="true" path="gadgets"/>

    @endsection
</x-lareon::admin-editor-layout>
