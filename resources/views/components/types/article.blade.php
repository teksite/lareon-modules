@props(['value'=>[]])
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="Article" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="Article" class="hidden"  type="hidden"/>
    <div class="mb-3 md:w-1/2">
        <x-lareon::input.label title="{{__('specific type')}}" for="seo_type_specific"/>
        <x-lareon::input.select id="seo_type_specific" name="seo[schema][type]" class="block w-full mb-3">
            @foreach(config('seo.schema-type.pageType.Article') as $key=>$description)
                <option value="{{$key}}" {{isset($value['type']) && $value['type'] ==$key ? 'selected':''}}>
                    <span class="font-bold">{{__($key)}}</span>
                </option>
            @endforeach
        </x-lareon::input.select>
        <x-lareon::input.error :messages="get_error($errors , 'seo[schema][type]')"/>
    </div>
    <div class="mb-3">
        <x-lareon::input.label title="{{__('headline')}}" for="schema_headline"/>
        <x-lareon::input.text id="schema_headline" name="seo[schema][headline]" class="block w-full mb-3" value="{{$value['headline'] ?? $value['title'] ?? ''}}"/>
        <x-lareon::input.error :messages="$errors->get('seo.schema.headline')"/>
    </div>
    <div class="mb-3 ">
        <x-lareon::input.label title="{{__('description')}}" for="schema_description"/>
        <x-lareon::input.textarea id="schema_description" name="seo[schema][description]" class="block w-full mb-3">{{$value['description'] ?? ''}}</x-lareon::input.textarea>
        <x-lareon::input.error :messages="$errors->get('seo.schema.description')"/>
    </div>
    <x-seo::sections.author :value="$value['author'] ?? []"/>
    <x-seo::sections.publisher :value="$value['publisher'] ?? []"/>
    <div class="mb-3 ">
        <x-lareon::dynamic.single name="seo[schema][images]" :title="__('images')" :value="old('seo.schema.images') ?? $value['images']  ?? []"/>
        <x-lareon::input.error  :message="get_error($errors , 'seo[schema][images]')"/>
        <x-lareon::input.error  :message="get_error($errors , 'seo[schema][images][*]')"/>
    </div>



</section>
