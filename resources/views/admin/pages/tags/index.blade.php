<x-lareon::admin-entry-layout>
    @section('title', __(':title list',['title'=>__('tags')]))
    @section('formRoute', route('admin.tags.store'))
    @section('description', __('tags are used to categorize and organize topics and let clients to find related contents'))
    @can('admin.tag.create')
        @section('form')
            <x-lareon::sections.text :title="__('title')" name="title" :placeholder="__('enter a unique :title' ,['title'=>__('title')])" :required="true"/>
        @endsection
    @endcan
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title') ,]">
                @foreach($tags as $key=>$tag)
                    <tr>
                        <td class="p-3">{{$tags->firstItem() + $key}}</td>
                        <td>{{$tag->title}}</td>
                        <td>
                            <div class="action">
                                <x-lareon::link.edit :href="route('admin.tags.edit' , $tag)" can="admin.tag.edit"/>
                                <x-lareon::link.delete :href="route('admin.tags.destroy' , $tag)" can="admin.tag.delete"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-lareon::table>
            {{$tags->appends($_GET)->links()}}

        </x-lareon::box>
    @endsection

</x-lareon::admin-entry-layout>
