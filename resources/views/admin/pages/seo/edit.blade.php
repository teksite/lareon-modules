<x-lareon::admin-layout type="update">
    @section('title', __('edit the :title',['title'=>__('post')]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('post')]))
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <form action="{{route('admin.blog.seo.update')}}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="key" value="blog_index">
                <input type="hidden" name="seo[sitemap][url]" value="{{route('blog.posts.index')}}">
                <input type="hidden" name="seo[sitemap][group]" value="blog">
                <x-seo::sections.instance-editor  :value="old('seo')" :accordion="false" />
                <div class="mt-6 flex items-center justify-end">
                    <x-lareon::button.solid >{{__('update')}}</x-lareon::button.solid>
                </div>
            </form>
        </div>
    </div>
</x-lareon::admin-layout>
