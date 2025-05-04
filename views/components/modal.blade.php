@props([ 'name', 'show' => false,  'maxWidth' => '2xl' ,'id'=>rand(100,10000)])
@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '5xl' => 'sm:max-w-5xl',
    ][$maxWidth];
@endphp

<div id="{{$id}}"
    x-data="{show: @js($show)}"
    x-init="$watch('show', value =>  value ? document.body.classList.add('overflow-y-hidden'): document.body.classList.remove('overflow-y-hidden'))"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null" x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false" x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto p-6 sm:px-0 z-50" style="display: {{ $show ? 'block' : 'none' }};">
    <div x-show="show" x-on:click="show = false" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-zinc-900 opacity-90"></div>

    </div>

    <div x-show="show" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="mb-6 bg-slate-50 p-6 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto relative">
        <button type="button" title="{{__('close')}}" x-on:click="show =false" class="text-red-600 hover:text-red-800 z-50 absolute top-1 end-3 text-xl cursor-pointer font-bold">
            x
        </button>
        {{ $slot }}
    </div>

</div>
