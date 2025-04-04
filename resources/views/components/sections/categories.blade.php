@props(['name'=>'categories[]' , 'value'=>[] ,'open'=>false ,'accordion'=>true ,'multiple'=>false])
@php
    $allCategories=\Lareon\Modules\Blog\App\Models\Category::query()->where('parent_id',0)->get()->map(fn($category) =>
        $category->descendantsAndSelf()->orderBy('title')->get())
    ->flatten();$random='cats_selection_'.rand(100,999);
    $value=is_array($value) ? $value : [$value];
        $stringifiedName=arrayToDot($name);

@endphp

@if($accordion)
   <x-lareon::accordion.box :title="__('category')" :open="$open">
       <x-lareon::input.select :multiple="$multiple" aria-title="{{__('category')}}" id="{{$random}}"  name="{{$name}}" class="block mt-1 w-full">
           @foreach($allCategories as $cat)
               <option value="{{$cat->id}}" class="text-sm {{$cat->parent_id =='0' ? 'font-bold' :''}}" {{in_array($cat->id , $value) ? 'selected' :''}}>
                   {{$cat->title}}
               </option>
           @endforeach
       </x-lareon::input.select>
       <x-lareon::input.error :messages="$errors->get($stringifiedName)" class="mt-2"/>
       <x-lareon::input.error :messages="$errors->get($stringifiedName.'.*')" class="mt-2"/>
   </x-lareon::accordion.box>
@else
    <x-lareon::box>
    <x-lareon::input.label for="{{$random}}" :title="__('category')" class=""/>
    <x-lareon::input.select :multiple="$multiple" aria-title="{{__('category')}}" id="{{$random}}"  name="{{$name}}" class="block mt-1 w-full">
        @foreach($allCategories as $cat)
            <option value="{{$cat->id}}" class="text-sm {{$cat->parent_id =='0' ? 'font-bold' :''}}" {{in_array($cat->id , $value) ? 'selected' :''}}>
                {{$cat->title}}
            </option>
        @endforeach
    </x-lareon::input.select>
    <x-lareon::input.error :messages="$errors->get($stringifiedName)" class="mt-2"/>
    <x-lareon::input.error :messages="$errors->get($stringifiedName.'.*')" class="mt-2"/>
    </x-lareon::box>
@endif
