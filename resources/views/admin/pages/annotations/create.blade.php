<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('annotation')]))
    @section('description', __('in this window you can create a new :title',['title'=>__('annotation')]))
    @section('formRoute', route('admin.blog.annotations.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.annotations.index')" :title="__('all :title',['title'=>__('annotations')])" color="index"/>
    @endsection
    @section('form')
        <x-lareon::sections.text :value="old('title')" :title="__('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.textarea :title="__('excerpt')" name="excerpt" :placeholder="__('write a :title' ,['title'=>__('excerpt')])" :required="false" :open="true">{{old('excerpt')}}</x-lareon::sections.textarea>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" :required="false" rows="30" :open="true">{{old('body')}}</x-lareon::sections.editor>
    @endsection

</x-lareon::admin-editor-layout>
