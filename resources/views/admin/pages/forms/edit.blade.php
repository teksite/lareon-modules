<x-lareon::admin-editor-layout type="update"  :instance="$form">
    @section('title', __('edit the :title',['title'=>__('form') . " ($form->title)"]))
    @section('description', __('in this window you can edit the :title' ,['title'=>__('form') . " ($form->title)"]))

    @section('formRoute', route('admin.questionnaire.forms.update', $form))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.questionnaire.forms.index')" :title="__('all :title',['title'=>__('forms')])" color="index"/>
        <x-lareon::link.btn-outline :href="route('admin.questionnaire.forms.create')" :title="__('new :title',['title'=>__('form')])" color="create"/>
    @endsection
    @section('header.end')
        @parent
            <x-lareon::link.delete :href="route('admin.questionnaire.forms.destroy', $form)" can="admin.questionnaire.form.delete"/>
    @endsection
    @section('form')
        <x-lareon::sections.checkbox :title="__('active')" name="active" value="1" :checked="old('active' , $form->active) "  :accordion="false"/>
        <x-lareon::sections.title :value="old('title') ?? $form->title" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.textarea dir="ltr" :title="__('body')" name="body" :placeholder="__('inset form fields (html)')" :required="false" rows="15" :open="true">{{old('body') ?? $form->body}}</x-lareon::sections.textarea>
        <x-questionnaire::sections.announcements :value="old('announcements') ?? $form->announcement?->toArray()" />
        <x-questionnaire::sections.rules :value="old('rules') ?? $form->validationRules?->rules"/>
    @endsection
    @section('aside')
        <x-lareon::sections.template :value="old('template') ?? $form->template" :accordion="true" path="forms"/>
        <x-lareon::box>
            <x-lareon::sections.checkbox :title="__('has file')" name="has_file" value="1" :checked="old('has_file',$form->has_file) " :accordion="true"/>
            <x-lareon::sections.checkbox :title="__('response to client')" name="response_client" value="1" :checked="old('response_client',$form->response_client) " :accordion="true"/>
        </x-lareon::box>
    @endsection
</x-lareon::admin-editor-layout>
