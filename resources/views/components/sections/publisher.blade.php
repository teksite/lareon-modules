@props([ 'name'=>'seo[schema]','value'=>[]] )
@php
    $rand=rand(10,1000).\Illuminate\Support\Str::random(8).rand(10,1000)
@endphp
<fieldset class="fieldset">
    <legend>
        {{__('publisher')}}
    </legend>
    <div class="mb-3 grid gap-3 md:grid-cols-3">
        <div>
            <x-lareon::input.label :title="__('publisher name')" for="{{$rand}}_schema_publisher_name"/>
            <x-lareon::input.text type="name" id="{{$rand}}_schema_publisher_name" name="{{$name}}[publisher][name]" value="{{$value['name'] ?? ''}}" class="block w-full mb-3"/>
            <x-lareon::input.error :messages="get_error($errors, $name.'[publisher][name]')"/>
        </div>
        <div>
            <x-lareon::input.label :title="__('publisher logo')" for="{{$rand}}_schema_publisherUrl"/>
            <x-lareon::input.text type="url" dir="ltr" id="{{$rand}}_schema_publisherUrl" name="{{$name}}[publisher][url]" value="{{$value['url'] ?? ''}}" class="block w-full mb-3"/>
            <x-lareon::input.error :messages="get_error($errors, $name.'[publisher][url]')"/>
        </div>
    </div>
</fieldset>
