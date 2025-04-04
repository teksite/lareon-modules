<x-lareon::admin-editor-layout type="update"  :instance="$category">
    @section('title', __('edit the :title',['title'=>__('category') . " ($category->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('category') . " ($category->title)"]))
    @section('formRoute', route('admin.blog.categories.update', $category))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.categories.index')" :title="__('all :title',['title'=>__('categories')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.blog.categories.create')" :title="__('new :title',['title'=>__('categories')])" color="create" can="admin.category.create"/>
    @endsection
    @section('header.end')
        @parent
            <x-lareon::link.delete :href="route('admin.blog.categories.destroy', $category)" can="admin.category.delete"/>
    @endsection
    @section('form')
        <x-lareon::sections.title :value="old('title') ?? $category->title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true" :open="true"/>
        <x-lareon::sections.slug :value="old('slug') ?? $category->slug" :placeholder="__('enter a unique :title' ,['title'=>__('slug')])" :required="true" :open="true" :link="$category->path()"/>
        <x-lareon::sections.textarea :title="__('excerpt')" name="excerpt" :placeholder="__('write a :title' ,['title'=>__('excerpt')])" >{{old('excerpt') ?? $category->excerpt}}</x-lareon::sections.textarea>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" rows="12">{{old('body') ?? $category->body}}</x-lareon::sections.editor>
    @endsection
    @section('aside')
        <x-lareon::sections.image value="{{old('featured_image') ?? $category->featured_image}}" :title="__('featured image')" name="featured_image" />
        <x-blog::categories-creation :category="$category" :categories="$categories" :open="true"/>
    @endsection
</x-lareon::admin-editor-layout>


