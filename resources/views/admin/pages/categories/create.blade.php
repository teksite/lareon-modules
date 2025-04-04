<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('category')]))
    @section('description', __('in this window you can create a new :title',['title'=>__('category')]))
    @section('formRoute', route('admin.blog.categories.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.categories.index')" :title="__('all :title',['title'=>__('categories')])" color="index"/>
    @endsection
    @section('form')
        <x-lareon::sections.title :value="old('title')" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.slug :value="old('slug')" :placeholder="__('enter a unique :title' ,['title'=>__('slug')])" :required="true" />
        <x-lareon::sections.textarea :title="__('excerpt')" name="excerpt" :placeholder="__('write a :title' ,['title'=>__('excerpt')])" :open="false">{{old('excerpt')}}</x-lareon::sections.textarea>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" rows="12" :open="false">{{old('body')}}</x-lareon::sections.textarea>
    @endsection
    @section('aside')
        <x-lareon::sections.image value="{{old('featured_image')}}" :title="__('featured image')" name="featured_image" />
        <x-blog::categories-creation :categories="$categories" :open="true"/>
    @endsection
</x-lareon::admin-editor-layout>
