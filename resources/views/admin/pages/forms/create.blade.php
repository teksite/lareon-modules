<x-lareon::admin-editor-layout>
    @section('title', __('new :title',['title'=>__('form')]))
    @section('description', __('in this window you can create a new :title',['title'=>__('form')]))
    @section('formRoute', route('admin.questionnaire.forms.store'))
    @section('header.start')
        <x-lareon::link.btn-outline :href="route('admin.questionnaire.forms.index')" :title="__('all :title',['title'=>__('forms')])" color="index"/>
    @endsection
    @section('form')
        <x-lareon::sections.checkbox :title="__('active')" name="active" value="1" :checked="old('active') "  :accordion="false"/>
        <x-lareon::sections.title :value="old('title')" name="title" :placeholder="__('enter a unique :title',['title'=>__('title')])" :required="true"/>
        <x-lareon::sections.textarea dir="ltr" :title="__('body')" name="body" :placeholder="__('inset form fields (html)')" :required="false" rows="15" :open="true">{{old('body')}}</x-lareon::sections.textarea>

        <x-questionnaire::sections.announcements :value="old('announcements')" />

        <x-questionnaire::sections.rules :value="old('rules')"/>

    @endsection
    @section('aside')
        <x-lareon::sections.template :value="old('template')" :accordion="true" path="forms/templates"/>
        <x-lareon::box>
            <x-lareon::sections.checkbox :title="__('has file')" name="has_file" value="1" :checked="old('has_file')" :accordion="true"/>
            <x-lareon::sections.checkbox :title="__('response to client')" name="response_client" value="1" :checked="old('response_client') " :accordion="true"/>
        </x-lareon::box>
    @endsection

</x-lareon::admin-editor-layout>
