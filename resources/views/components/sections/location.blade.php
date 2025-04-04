@props(['name','value'=>[] ])
@php
    $rand=rand(10,1000).\Illuminate\Support\Str::random(8).rand(10,1000)
@endphp

<fieldset class="fieldset">
    <legend class="legend">{{__('location')}}</legend>
    <div class="mb-3">
        <x-lareon::input.label for="{{$rand}}_country" :title="__('country')"/>
        <x-lareon::input.select name="{{$name}}[location][country]" id="{{$rand}}_country" :required="true">
            @foreach(config('area') as $key=>$vl)
                <option value="{{$key}}"
                    {{isset($value['country']) && $value['country']=== $key ? 'selected' :''}}>
                    {{__($vl)}}
                </option>
            @endforeach
        </x-lareon::input.select>
        <x-lareon::input.error :messages="get_error($errors , '{{$name}}[location][country]')"/>
    </div>
    {{--City--}}
    <div class="mb-3">
        <x-lareon::input.label for="{{$rand}}_city" :title="__('city')"/>
        <x-lareon::input.text id="{{$rand}}_city" name="{{$name}}[location][city]"  :value="$value['city'] ?? ''" :placeholder="__('city')" :required="true"/>
        <x-lareon::input.error :messages="get_error($errors , '{{$name}}[location][city]')"/>
    </div>
    {{--Street--}}
    <div class="mb-3">
        <x-lareon::input.label for="{{$rand}}_street" :title="__('street')"/>
        <x-lareon::input.text id="{{$rand}}_street" name="{{$name}}[location][street]"  :value="$value['street'] ?? ''" :placeholder="__('street')" :required="true"/>
        <x-lareon::input.error :messages="get_error($errors , '{{$name}}[location][street]')"/>
    </div>
    {{--Zip Code--}}
    <div class="mb-3">
        <x-lareon::input.label for="{{$rand}}_zip_code" :title="__('zip code')"/>
        <x-lareon::input.text id="{{$rand}}_zip_code" dir="ltr" type="number" name="{{$name}}[location][zip_code]"  :value="$value['zip_code'] ?? ''" :placeholder="__('zip code')" :required="true"/>
        <x-lareon::input.error :messages="get_error($errors , '{{$name}}[location][zip_code]')"/>
    </div>

</fieldset>
