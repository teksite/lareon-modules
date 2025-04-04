@props(['category'=>null , 'categories'=>[] ,'open'=>false])
<x-lareon::accordion.box :title="__('parent category')" :open="$open">
    <x-lareon::input.label for="category-creation" :title="__('parent')" class=""/>
    <x-lareon::input.select id="category-creation" name="parent_id" class="block mt-1 w-full">
        <option value="0" {{old('parent_id') == 0  ? 'selected':''}} class="font-bold">
            {{__('as parent')}}
        </option>
        @if(count($categories))
            @foreach($categories as $cat)
                @if(!is_null($category) && ($category->id == $cat->id || in_array($cat->id,$category->descendants->pluck('id')->toArray()))
                    || $cat->label=='uncategorized-category')
                    @continue
                @endif
                <option class="{{$cat->parent_id =='0' ? 'font-bold' :''}}" value="{{$cat->id}}" {{isset($category) && $category->parent_id == $cat->id ? 'selected':''}} >
                    {{$cat->title}}
                </option>
            @endforeach
        @endif
    </x-lareon::input.select>
    <x-lareon::input.error :messages="$errors->get('parent_id')" class="mt-2"/>
</x-lareon::accordion.box>
