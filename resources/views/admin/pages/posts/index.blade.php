<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('posts')]))
    @section('description', __('posts are content entry on a website, used for articles, news, or updates. they typically include text, images, and other media and can be categorized and timestamped'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.posts.create')" :title="__('create a new one')" color="create" can="admin.blog.post.create"/>
        <x-lareon::link.trash :count="$count" :href="route('admin.blog.posts.trash.index')" :title="__('trash :title',['title'=>__('posts')])" color="create" can="admin.blog.post.create"/>
    @endsection
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title'),]">
                @if(count($posts))
                @foreach($posts as $key=>$post)
                    <tr>
                        <td class="p-3">{{$posts->firstItem() + $key}}</td>
                        <td>{{$post->title}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.edit :href="route('admin.blog.posts.edit' , $post)" can="admin.blog.post.edit"/>
                                <x-lareon::link.delete :href="route('admin.blog.posts.destroy' , $post)" can="admin.blog.post.delete"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <p class="text-center">
                                {{__('no item has been found')}}.
                            </p>
                        </td>
                    </tr>
                @endif
            </x-lareon::table>
            {{$posts->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
