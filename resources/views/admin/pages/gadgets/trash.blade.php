<x-lareon::admin-trash-layout :trash="route('admin.blog.annotations.trash.index')" :index="route('admin.blog.annotations.index')" title="{{__('annotations')}}">
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
                                <x-lareon::link.restore :href="route('admin.blog.annotations.trash.reinstate' , $annotation->id)" can="admin.blog.annotation.edit"/>
                                <x-lareon::link.delete :href="route('admin.blog.annotations.trash.prune' , $annotation->id)" can="admin.blog.annotation.trash"/>
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
