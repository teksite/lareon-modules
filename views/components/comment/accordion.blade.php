
<div x-data="{open: false }" class="transition duration-150 ease-in-out xbox" role="region" aria-labelledby="replies-button">
    <x-button.outline
        @click="open=!open"
        x-bind:title="open ? '{{__('close')}}' : '{{__('open')}}'"
        x-bind:aria-expanded="open"
        aria-label="{{__('Toggle replies section')}}" color="green" type="button" role="button" class="p-1 text-xs" id="replies-button">
        {{__('replies')}}
    </x-button.outline>
    <div class="px-1" x-show="open" x-cloak
        x-transition:enter="transition-transform transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0 transform"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-end="opacity-0 transform">
        {!! $slot ?? '' !!}
    </div>
</div>
