<x-lareon::admin-editor-layout type="update" :instance="$inbox">
    @section('title', __('edit the :title',['title'=>__('inbox') . '('.$inbox->form->title.')']))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('inbox') . " ".$inbox->form->title]))

    @section('formRoute', route('admin.questionnaire.inboxes.update', $inbox))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.questionnaire.inboxes.index' ,['form'=>$inbox->form_id])"
                                    :title="__('all :title',['title'=>__('inbox')])" color="index"/>
    @endsection
    @section('header.end')
        @parent
        <x-lareon::link.delete :href="route('admin.questionnaire.inboxes.destroy', $inbox)"
                               can="admin.questionnaire.inbox.delete"/>
    @endsection
    @section('form')
        <x-lareon::box class="overflow-x-scroll">
            <table class="w-full ">
                @foreach($inbox->data ?? [] as $key=>$data)
                    <tr class="border border-slate-200">
                        <th class="p-3">{{$key}}</th>
                        <td class="p-3">{{is_array($data) ? implode(', ', $data) : $data}}</td>
                    </tr>
                @endforeach
                <tr class="border border-slate-200">
                    <th class="p-3">IP</th>
                    <td class="p-3">{{$inbox->ip_address}}</td>
                </tr>
                <tr class="border border-slate-200">
                    <th class="p-3">{{__('url')}}</th>
                    <td class="p-3">{{$inbox->url}}</td>
                </tr>
                <tr class="border border-slate-200">
                    <th class="p-3">{{__('read by')}}</th>
                    <td class="p-3">{{$inbox->user->name}}</td>
                </tr>
            </table>
        </x-lareon::box>
        <div class="p-6">
            <h3>
                {{__('notes')}}
            </h3>
            @foreach($inbox->note as $item)
                <p class="mb-3 text-sm">
                    <span class="font-bold">{{$item['author']}}</span>
                    {{$item['note']}}
                </p>
            @endforeach
        </div>
    @endsection
    @section('aside')
        <x-lareon::sections.textarea :title="__('note')" name="note" :placeholder="__('message')" :required="false"
                                     rows="3" :open="true">{{old('note')}}</x-lareon::sections.textarea>
    @endsection

</x-lareon::admin-editor-layout>
