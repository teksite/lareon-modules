<x-lareon::admin-editor-layout type="update"  :instance="$annotation">
    @section('title', __('edit the :title',['title'=>__('annotation') . " ($annotation->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('annotation') . " ($annotation->title)"]))

    @section('formRoute', route('admin.blog.annotations.update', $annotation))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.annotations.index')" :title="__('all :title',['title'=>__('annotations')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.blog.annotations.create')" :title="__('new :title',['title'=>__('annotation')])" color="create" can="admin.blog.annotation.create"/>
    @endsection
    @section('header.end')
        @parent
            <x-lareon::link.delete :href="route('admin.blog.annotations.destroy', $annotation)" can="admin.blog.annotation.delete"/>
    @endsection
    @section('form')
        <x-lareon::sections.text :value="old('title') ?? $annotation->title" :title="__('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.textarea :title="__('excerpt')" name="excerpt" :placeholder="__('write a :title' ,['title'=>__('excerpt')])" :required="false" :open="true">{{old('excerpt') ?? $annotation->excerpt}}</x-lareon::sections.textarea>
        <x-lareon::sections.editor :title="__('body')" name="body" :placeholder="__('write a :title' ,['title'=>__('body')])" :required="false" rows="30" :open="true">{{old('body') ?? $annotation->body}}</x-lareon::sections.editor>
    @endsection
</x-lareon::admin-editor-layout>
