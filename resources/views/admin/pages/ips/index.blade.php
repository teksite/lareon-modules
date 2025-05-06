<x-lareon::admin-entry-layout>
    @section('title', __(':title list',['title'=>__('restricted ips')]))
    @section('formRoute', route('admin.settings.ips.store'))
    @section('description', __('tags are used to categorize and organize topics and let clients to find related contents'))
    @can('admin.tag.create')
        @section('form')
            <x-lareon::sections.text :title="__('ip')" name="ip_address" :placeholder="__('enter a unique :title' ,['title'=>__('ip')])" :required="true"/>
            <x-lareon::input.label :title="__('type')" name="type" :required="true" for="type"/>
            <x-lareon::input.select name="type" :required="true" id="type">
                <option value="blacklist">{{__('blacklist')}}</option>
                <option value="whitelist">{{__('whitelist')}}</option>
            </x-lareon::input.select>
        @endsection
    @endcan
    @section('list')
        <x-lareon::box>
            @if(config('lareon.fence.storage','file') ==='database')
                <x-lareon::table :headers="['id'=>'#','ip_address'=>__('ip'),'type'=>__('type') ,]">
                    @foreach($restrctips as $key=>$ip)
                        <tr>
                            <td class="p-3">{{$restrctips->firstItem() + $key}}</td>
                            <td>{{$ip->ip_address}}</td>
                            <td>{{$ip->type}}</td>
                            <td>
                                <div class="action">
                                    @can('admin.setting.edit')
                                        @php($random='id_form-'.rand(1000,9999))
                                        <form method="POST" action="{{route('admin.settings.ips.destroy')}}"
                                              id="{{$random}}" class="deltfrmItms">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="type" value="{{$ip->type}}">
                                            <input type="hidden" name="ip_address" value="{{$ip->ip_address}}">
                                            <button class="hover:bg-zinc-300 hover:cursor-pointer p-1 rounded-full">
                                                <i class="tkicon fill-none stroke-red-600 " data-icon="trash" size="18"
                                                   stroke-width="2"></i>
                                            </button>
                                        </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-lareon::table>
                {{$restrctips->appends($_GET)->links()}}
            @else
                <x-lareon::table :headers="['#',__('ip'),__('type'),]">
                    @foreach($restrctips as $ip)
                        <tr>
                            <td class="p-3">{{$loop->iteration}}</td>
                            <td>{{$ip['ip_address']}}</td>
                            <td>{{$ip['type']}}</td>
                            <td>
                                <div class="action">
                                    @can('admin.setting.edit')
                                        @php($random='id_form-'.rand(1000,9999))
                                        <form method="POST" action="{{route('admin.settings.ips.destroy')}}"
                                              id="{{$random}}" class="deltfrmItms">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="ip_address" value="{{$ip['ip_address']}}">
                                            <input type="hidden" name="type" value="{{$ip['type']}}">
                                            <button class="hover:bg-zinc-300 hover:cursor-pointer p-1 rounded-full">
                                                <i class="tkicon fill-none stroke-red-600 " data-icon="trash" size="18"
                                                   stroke-width="2"></i>
                                            </button>
                                        </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-lareon::table>
            @endif

        </x-lareon::box>
    @endsection

</x-lareon::admin-entry-layout>
