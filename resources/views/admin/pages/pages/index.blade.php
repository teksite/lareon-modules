<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('pages')]))
    @section('description', __('pages are fixed content on a website that rarely changes and displays the same information to visitors'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.pages.create')" :title="__('create a new one')" color="create" can="admin.page.create"/>
        <x-lareon::link.trash :count="$count" :href="route('admin.pages.trash.index')" :title="__('trash :title',['title'=>__('pages')])" color="create" can="admin.page.create"/>
    @endsection
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#',__('image'),'title'=>__('title'),'publish_status'=>__('publish status'),'published_at'=>__('published at'),]">
                @if(count($pages))
                    @foreach($pages as $key=>$page)
                        <tr>
                            <td class="p-3">{{$pages->firstItem() + $key}}</td>
                            <td class="p-3"><img src="{{$page->featured_image}}" alt="{{$page->title}}" width="90" height="60" loading="lazy" decoding="async" fetchpriority="low"></td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->publish_status}}</td>
                            <td>{{$page->published_at ?? $page->created_at}}</td>
                            <td>
                                <div class="action">
                                    <x-lareon::link.show :href="$page->path()"/>
                                    <x-lareon::link.edit :href="route('admin.pages.edit' , $page)" can="admin.page.edit"/>
                                    <x-lareon::link.delete :href="route('admin.pages.destroy' , $page)" can="admin.page.delete"/>
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
            {{$pages->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
