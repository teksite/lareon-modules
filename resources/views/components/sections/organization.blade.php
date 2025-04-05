@props(['name','value'=>[] ])
@php
    $rand=rand(10,1000).\Illuminate\Support\Str::random(8).rand(10,1000)
@endphp

<fieldset class="fieldset">
    <legend class="legend">{{__('company')}}</legend>
    {{--Type--}}
  <div class="mb-3 grid gap-3 md:grid-cols-2">
      <div>
          <x-lareon::input.label :title="__('company')" for="{{$rand}}_company_type"/>
          <x-lareon::input.select id="{{$rand}}_company_type" class="block w-full"  name="{{$name}}[company][type]">
              @foreach(config('seo.schema-type.pageType.JobPosition.CompanyType') as $type=>$title)
                  <option value="{{$type}}" {{isset($value['type']) && $value['type']==$type ? 'selected' : ''}}>{{__($title)}}</option>

              @endforeach
          </x-lareon::input.select>
      </div>
      <x-lareon::input.error :messages="get_error($errors , '{{$name}}[company][type]')"/>
      {{--name--}}
      <div >
          <x-lareon::input.label for="{{$rand}}_name" :title="__('name')"/>
          <x-lareon::input.text id="{{$rand}}_name" name="{{$name}}[company][name]"  :value="$value['name'] ??  $value['title'] ??''" :placeholder="__('name')" :required="true"/>
          <x-lareon::input.error :messages="get_error($errors , '{{$name}}[company][name]')"/>
      </div>
  </div>
  <div class="mb-3 grid gap-3 md:grid-cols-2">
      {{--url--}}
      <div >
          <x-lareon::input.label for="{{$rand}}_sameas" :title="__('url')"/>
          <x-lareon::input.text id="{{$rand}}_sameas" name="{{$name}}[company][sameas]" type="url" dir="ltr" :value="$value['sameas'] ?? config('app.url') ?? ''" :placeholder="__('url')" :required="true"/>
          <x-lareon::input.error :messages="get_error($errors , '{{$name}}[company][sameas]')"/>
      </div>
      {{--logo--}}
      <div>
          <x-lareon::input.label for="{{$rand}}_logo" :title="__(':title url' ,['title'=>__('logo')])"/>
          <x-lareon::input.text id="{{$rand}}_logo" name="{{$name}}[company][logo]" type="url" dir="ltr" :value="$value['logo'] ??''" :placeholder="__('url')" :required="true"/>
          <x-lareon::input.error :messages="get_error($errors , '{{$name}}[company][logo]')"/>
      </div>
  </div>

</fieldset>
