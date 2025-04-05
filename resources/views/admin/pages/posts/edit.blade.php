<x-lareon::admin-editor-layout type="update"  :instance="$post">
    @section('title', __('edit the :title',['title'=>__('post') . " ($post->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('post') . " ($post->title)"]))

    @section('formRoute', route('admin.blog.posts.update', $post))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.posts.index')" :title="__('all :title',['title'=>__('posts')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.blog.posts.create')" :title="__('new :title',['title'=>__('posts')])" color="create" can="admin.blog.post.create"/>
    @endsection
    @section('header.end')
        @parent
            <x-lareon::link.delete :href="route('admin.blog.posts.destroy', $post)" can="admin.blog.post.delete"/>
    @endsection
    @section('form')
        <x-lareon::sections.title :value="old('title') ?? $post->title" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.slug :link="$post->path()" :value="old('slug') ?? $post->slug" name="slug" :placeholder="__('enter a unique :title',['title'=>__('slug')])" :required="true"/>

        <x-lareon::sections.textarea :title="__('excerpt')" name="excerpt" :placeholder="__('write a :title' ,['title'=>__('excerpt')])" :required="false" :open="false">{{old('excerpt') ?? $post->excerpt}}</x-lareon::sections.textarea>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" :required="false" rows="30" :open="true">{{old('body') ?? $post->body}}</x-lareon::sections.editor>


        <x-seo::sections.instance-editor :instance="$post" :value="old('seo') ?? $post->getSeo()"/>


    @endsection
    @section('aside')
        <x-lareon::sections.image value="{{old('featured_image') ?? $post->featured_image}}" :title="__('featured image')" name="featured_image" />
        <x-blog::sections.categories name="categories[]" :value="$post->getCategories(['id'])->pluck('id')->toArray() ?? old('categories')" :accordion="false"/>
        <x-lareon::sections.template :value="old('template') ?? $post->template" :accordion="true" path="pages/posts/templates"/>
        <x-tag::sections.tag :value=" old('tags') ?? $post->tags->pluck('title')->toArray()"/>
        <x-lareon::sections.publish-status name="publish_status" :value="[$post->publish_status , $post->published_at]"/>
    @endsection
</x-lareon::admin-editor-layout>
