@props([ 'name'=>'seo[schema]','value'=>[]] )
@php
$rand=rand(10,1000).\Illuminate\Support\Str::random(8).rand(10,1000)
@endphp
<fieldset class="fieldset">
    <legend>
        {{__('author')}}
    </legend>
    <div class="mb-3 grid gap-3 md:grid-cols-3">
        <div>
            <x-lareon::input.label :title="__('author type')" for="{{$rand}}_schema_authorType"/>
            <x-lareon::input.select id="{{$rand}}_schema_authorType" name="{{$name}}[author][type]" class="block w-full mb-3">
                <option value="Person" {{isset($value['type']) && $value['type'] =='Person' ? 'selected': ''}}>
                    {{__('person')}}
                </option>
                <option
                    value="Organization" {{isset($value['type']) && $value['type'] =='Organization' ? 'selected' : ''}}>
                    {{__('organization')}}
                </option>
            </x-lareon::input.select>
            <x-lareon::input.error :messages="get_error($errors , $name.'[author][type]')"/>
        </div>
        <div>
            <x-lareon::input.label :title="__('author url')" for="{{$rand}}_schema_authorUrl"/>
            <x-lareon::input.text type="url" dir="ltr" id="{{$rand}}_schema_authorUrl" name="{{$name}}[author][url]" value="{{$value['url'] ?? ''}}" class="block w-full mb-3"/>
            <x-lareon::input.error :messages="get_error($errors, $name.'[author][url]')"/>
        </div>
        <div>
            <x-lareon::input.label :title="__('author name')" for="{{$rand}}_schema_authorName"/>
            <x-lareon::input.text id="{{$rand}}_schema_authorName" name="{{$name}}[author][name]"
                                  value="{{$value['name'] ?? ''}}" lass="block w-full mb-3"/>
            <x-lareon::input.error :messages="get_error($errors, $name.'[author][name]')"/>
        </div>
    </div>
</fieldset>
