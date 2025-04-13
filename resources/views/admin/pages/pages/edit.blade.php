<x-lareon::admin-editor-layout type="update"  :instance="$page">
    @section('title', __('edit the :title',['title'=>__('page') . " ($page->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('page') . " ($page->title)"]))

    @section('formRoute', route('admin.pages.update', $page))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.pages.index')" :title="__('all :title',['title'=>__('pages')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.pages.create')" :title="__('new :title',['title'=>__('pages')])" color="create" can="admin.page.create"/>
    @endsection
    @section('header.end')
        @parent
            <x-lareon::link.delete :href="route('admin.pages.destroy', $page)" can="admin.page.delete"/>
    @endsection
    @section('form')
        <x-lareon::sections.title :value="old('title') ?? $page->title" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.slug :link="$page->path()" :value="old('slug') ?? $page->slug" name="slug" :placeholder="__('enter a unique :title',['title'=>__('slug')])" :required="true"/>

        <x-lareon::sections.textarea :title="__('excerpt')" name="excerpt" :placeholder="__('write a :title' ,['title'=>__('excerpt')])" :required="false" :open="false">{{old('excerpt') ?? $page->excerpt}}</x-lareon::sections.textarea>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" :required="false" rows="30" :open="true">{{old('body') ?? $page->body}}</x-lareon::sections.editor>

        <x-seo::sections.instance-editor :instance="$page" :value="old('seo') ?? $page->getSeo()"/>


    @endsection
    @section('aside')
        <x-lareon::sections.image value="{{old('featured_image') ?? $page->featured_image}}" :title="__('featured image')" name="featured_image" />
        <x-lareon::sections.template :value="old('template') ?? $page->template" :accordion="true" path="pages/pages/templates"/>
        <x-tag::sections.tag :value=" old('tags') ?? $page->tags->pluck('title')->toArray()"/>
        <x-lareon::sections.publish-status name="publish_status" :value="[$page->publish_status , $page->published_at]"/>
    @endsection
</x-lareon::admin-editor-layout>
