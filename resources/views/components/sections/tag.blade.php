@props(['open'=>true ,'value'=>[]])
@php
    $preTags =count($value) ? $value : [];
    $tags=collect($preTags)->merge(\Lareon\Modules\Tag\App\Models\Tag::query()->cursor()->pluck('title')->toArray())->unique()
@endphp
<div>
    <x-lareon::accordion.box :title="__('tags')" :open="$open">
        <select aria-label="{{__('tags')}}" id="tags-box" class="block w-full select-box" name="tags[]" multiple data-creation="true" data-plugin="remove_button">
            @foreach($tags as $tag)
                <option {{ in_array($tag , $preTags) ? 'selected': ''}}  value="{{$tag}}">
                    {{$tag}}
                </option>
            @endforeach
        </select>
    </x-lareon::accordion.box>
    <x-lareon::input.error :messages="$errors->get('tags')" class="mt-2"/>
</div>
