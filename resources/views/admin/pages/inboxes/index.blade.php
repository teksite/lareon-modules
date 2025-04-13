<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('inboxes')]))
    @section('description', __('inboxes are collected data from forms'))
    @section('header.start')
        <div class="flex items-center gap-3">
            <x-lareon::input.label :title="__('forms')" />
            <x-lareon::input.select onchange="window.location = this.value" >
                <option value="{{route('admin.questionnaire.inboxes.index')}}">
                    {{__('all')}}
                </option>
                @foreach(\Lareon\Modules\Questionnaire\App\Models\Form::query()->select(['id' ,'title'])->get() as $form)
                    <option {{request()->input('form') == $form->id ? 'selected' :''}} value="{{route('admin.questionnaire.inboxes.index',['form'=>$form->id])}}">
                        {{$form->title}}
                    </option>
                @endforeach
            </x-lareon::input.select>
        </div>
        <x-lareon::link.trash :count="$count" :href="route('admin.questionnaire.inboxes.trash.index')" :title="__('trash :title',['title'=>__('inboxes')])" color="create" can="admin.questionnaire.inbox.create"/>
    @endsection
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','form_id'=>__('form'),'created_at '=>__('created at'),'read_at '=>__('read at'),'url '=>__('url'),]">
                @if(count($inboxes))
                    @foreach($inboxes as $key=>$inbox)
                        <tr class="{{$inbox->read_at ===null ? 'font-bold' : ''}}">
                            <td class="p-3">{{$inboxes->firstItem() + $key}}</td>
                            <td>{{$inbox->form->title}}</td>
                            <td>{{dateAdapter($inbox->created_at)}}</td>
                            <td>{{dateAdapter($inbox->read_at)}}</td>
                            <td class="text-sm">{{$inbox->url}}</td>
                            <td>
                                <div class="action">
                                    <x-lareon::link.edit :href="route('admin.questionnaire.inboxes.edit' , ['inbox'=>$inbox])" can="admin.questionnaire.inbox.edit" />
                                    <x-lareon::link.delete :href="route('admin.questionnaire.inboxes.destroy' , ['inbox'=>$inbox])" can="admin.questionnaire.inbox.delete" />
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
            {{$inboxes->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
