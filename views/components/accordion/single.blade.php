@props(['open'=>false,'title'=>null ,'accordion'=>true])

@php
    $randomSec =\Illuminate\Support\Str::random(6).rand(999, 1000);
@endphp
@if($accordion)
    <div x-data="{open: @js($open) }" class="transition duration-150 ease-in-out xbox">
        <button @click="open=!open" x-bind:title="open ? '{{__('close')}}' : '{{__('open')}}'" type="button"
                role="button" class="ps-3 py-1 pe-1 w-full flex items-center gap-1">
            <x-lareon::input.label for="acc-title-{{$randomSec}}" title="{{__($title)}}"/>
            <i :class="{'!-rotate-90':open , '!-rotate-0':!open}" class="tkicon ease-in-out transition-all me-0 ms-auto icon-accordion fill-none stroke-slate-400" size="9" data-icon="angle-left"></i>
        </button>
        <div x-show="open" x-cloak class="px-1"
             x-transition:enter="transition-transform transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0 transform"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0 transform">
            {!! $slot ?? '' !!}
        </div>
    </div>
@else
    <x-lareon::input.label for="acc-title-{{$randomSec}}" title="{{__($title)}}"/>
    <div>
        {!! $slot ?? '' !!}
    </div>
@endif
