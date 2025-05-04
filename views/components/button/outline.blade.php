@props(['type'=>'submit' , 'color'=>null , 'value'=>null])
@php

    $class=match (true){
        in_array($color ,['red','danger'])=>'border-red-600 hover:bg-red-900 text-red-600 text-red-600',
        in_array($color ,['create','green'])=>'border-green-600 hover:bg-green-900 text-green-600 text-green-600',
        in_array($color ,['update','blue'])=>'border-blue-600 hover:bg-blue-900 text-blue-600 text-blue-600',
        in_array($color ,['yellow','warning'])=>'border-yellow-600 hover:bg-yellow-900 text-yellow-600 text-yellow-600',
        in_array($color ,['teal','index'])=>'border-teal-600 hover:bg-teal-900 text-teal-600 text-teal-600',
         default=> 'border-gray-600 hover:bg-gray-900 text-gray-600 text-gray-600'
    };
@endphp
<button
    type="{{$type}}" {{$attributes->merge(['class'=> "border rounded text-sm px-3 py-2 shadow font-semibold hover:cursor-pointer select-none $class"])}}>
    {!! $value ?? $slot !!}
</button>

