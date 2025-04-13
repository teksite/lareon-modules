<x-lareon::admin-list-layout>
    @section('title', __(':title list',['title'=>__('forms')]))
    @section('description', __('forms are used to collect user input, such as contact information, or feedback'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.questionnaire.forms.create')" :title="__('create a new one')" color="create" can="admin.questionnaire.form.create"/>
        <x-lareon::link.trash :count="$count" :href="route('admin.questionnaire.forms.trash.index')" :title="__('trash :title',['title'=>__('forms')])" color="create" can="admin.questionnaire.form.create"/>
    @endsection
    @section('list')
        <x-lareon::box>
            <x-lareon::table :headers="['id'=>'#','title'=>__('title'),'created_at '=>__('created at'),]">
                @if(count($forms))
                    @foreach($forms as $key=>$form)
                        <tr>
                            <td class="p-3">{{$forms->firstItem() + $key}}</td>
                            <td>{{$form->title}}</td>
                            <td>{{$form->created_at}}</td>
                            <td>
                                <div class="action">
                                    <x-lareon::link.sub :href="route('admin.questionnaire.forms.show' , $form)"  can="admin.questionnaire.form.edit" />
                                    <x-lareon::link.edit :href="route('admin.questionnaire.forms.edit' , $form)" can="admin.questionnaire.form.edit" />
                                    <x-lareon::link.delete :href="route('admin.questionnaire.forms.destroy' , $form)" can="admin.questionnaire.form.delete" />
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
            {{$forms->appends($_GET)->links()}}
        </x-lareon::box>
    @endsection

</x-lareon::admin-list-layout>
