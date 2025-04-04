<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('annotations')]))
    @section('description', __('annotations are a type of article that can be attached to various content types, including software and product pages, to describe the main content. they are primarily used for SEO'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.blog.annotations.create')" :title="__('create a new one')" color="create" can="admin.blog.annotation.create"/>
        <x-lareon::link.trash :count="$count" :href="route('admin.blog.annotations.trash.index')" :title="__('trash :title',['title'=>__('annotations')])" color="create" can="admin.blog.annotation.create"/>

    @endsection
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title'),]">
                @if(count($annotations))
                @foreach($annotations as $key=>$annotation)
                    <tr>
                        <td class="p-3">{{$annotations->firstItem() + $key}}</td>
                        <td>{{$annotation->title}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.edit :href="route('admin.blog.annotations.edit' , $annotation)" can="admin.blog.annotation.edit"/>
                                <x-lareon::link.delete :href="route('admin.blog.annotations.destroy' , $annotation)" can="admin.blog.annotation.delete"/>
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
            {{$annotations->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
