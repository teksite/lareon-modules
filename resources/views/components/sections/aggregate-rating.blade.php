@props(['name','value'=>[]] )
@php
    $rand=rand(10,1000).\Illuminate\Support\Str::random(8).rand(10,1000)
@endphp
<fieldset class="fieldset">
    <legend class="legend">{{__('aggregate rating')}}</legend>
    {{--rating value--}}
   <div class="div mb-3 md:grid-cols-2 gap-3 grid">
        <div class="">
            <x-lareon::input.label for="{{$rand}}_ratingValue" :title="__('rating value')"/>
            <x-lareon::input.text id="{{$rand}}_ratingValue" name="{{$name}}[aggregateRating][ratingValue]" type="number"  min="0"  dir="ltr" :value="$value['ratingValue'] ?? 0" :required="true"/>
            <x-lareon::input.error :messages="get_error($errors , '{{$name}}[aggregateRating][ratingValue]')"/>
        </div>
        {{--rating count--}}
        <div class="">
            <x-lareon::input.label for="{{$rand}}_ratingCount" :title="__('rating count')"/>
            <x-lareon::input.text id="{{$rand}}_ratingCount" name="{{$name}}[aggregateRating][ratingCount]"  type="number" min="0"  dir="ltr" :value=" $value['ratingCount'] ?? 0" :required="true"/>
            <x-lareon::input.error :messages="get_error($errors , '{{$name}}[aggregateRating][ratingCount]')"/>
        </div>
        <div class="">
            <x-lareon::input.label for="{{$rand}}_bestRating" :title="__('best rating')"/>
            <x-lareon::input.text id="{{$rand}}_bestRating" name="{{$name}}[aggregateRating][bestRating]" type="number"  dir="ltr" :value="$value['bestRating'] ?? 5" :required="true"/>
            <x-lareon::input.error :messages="get_error($errors , '{{$name}}[aggregateRating][bestRating]')"/>
        </div>
        {{--rating count--}}
        <div class="">
            <x-lareon::input.label for="{{$rand}}_worstRating" :title="__('worst rating')"/>
            <x-lareon::input.text id="{{$rand}}_worstRating" name="{{$name}}[aggregateRating][worstRating]"  type="number" dir="ltr" min="0" :value="$value['worstRating'] ?? 0" :required="true"/>
            <x-lareon::input.error :messages="get_error($errors , '{{$name}}[aggregateRating][worstRating]')"/>
        </div>
    </div>
</fieldset>
