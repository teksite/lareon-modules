<x-lareon::admin-editor-layout type="update"  :instance="$tag">
    @section('title', __('edit the :title',['title'=>__('tag'). " ($tag->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('tag') . " ($tag->title)"]))
    @section('formRoute', route('admin.tags.update', $tag))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.tags.index')" :title="__('all :title',['title'=>__('tags')])" color="index"/>
    @endsection
    @section('header.end')
        @parent
        <x-lareon::link.trash :href="route('admin.tags.destroy', $tag)" can="admin.tag.delete"/>
    @endsection
    @section('form')
        <x-lareon::sections.text :value="$tag->title" :title="__('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
    @endsection
</x-lareon::admin-editor-layout>
