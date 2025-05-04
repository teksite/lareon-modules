@props(['title'=>null ,'required'=>false])
<label {{$attributes->merge(['class'=>'text-zinc-600 font-bold text-sm mb-1 block select-none' ])}}>
{!! $title ?? $slot ?? '' !!}  {!! $required  ? "<span class='text-sm text-red-600 required_symbol'>*</span>" : '' !!}
</label>
