<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('page')]))
    @section('description', __('in this window you can create a new :title',['title'=>__('page')]))
    @section('formRoute', route('admin.pages.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.pages.index')" :title="__('all :title',['title'=>__('pages')])" color="index"/>
    @endsection
    @section('form')
        <x-lareon::sections.title :value="old('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.slug :value="old('slug')" name="slug" :placeholder="__('enter a unique :title',['title'=>__('slug')])" :required="true"/>

        <x-lareon::sections.textarea :title="__('excerpt')" name="excerpt" :placeholder="__('write a :title' ,['title'=>__('excerpt')])" :required="false" :open="false">{{old('excerpt')}}</x-lareon::sections.textarea>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" :required="false" rows="30" :open="true">{{old('body')}}</x-lareon::sections.editor>

        <x-seo::sections.instance-editor :value="old('seo')"/>
    @endsection
    @section('aside')
        <x-lareon::sections.image value="{{old('featured_image')}}" :title="__('featured image')" name="featured_image" />
        <x-lareon::sections.template :value="old('template')" :accordion="true" path="pages/pages/templates"/>
        <x-tag::sections.tag :value="old('tags')"/>
        <x-lareon::sections.publish-status name="publish_status" />
    @endsection

</x-lareon::admin-editor-layout>
