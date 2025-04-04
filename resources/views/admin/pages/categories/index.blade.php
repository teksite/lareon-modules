<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('categories')]))
    @section('description', __('by categories, user can be categorized your posts'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.categories.create')" :title="__('create a new one')" color="create" can="admin.blog.category.create"/>
    @endsection
    @section('list')
        <x-blog::categories-tree-layout  :categories="$categories"/>
    @endsection
</x-lareon::admin-list-layout>
