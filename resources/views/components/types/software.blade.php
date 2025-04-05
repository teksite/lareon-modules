@props(['value'=>[]])
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="SoftwareApplication" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="SoftwareApplication" class="hidden"  type="hidden"/>
    <div class="grid gap-3 md:grid-cols-2 mb-3">
        <div class="">
            <x-lareon::input.label title="{{__('name')}}" for="schema_name"/>
            <x-lareon::input.text id="schema_name" name="seo[schema][name]" class="block w-full mb-3" value="{{$value['name'] ?? $value['title'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.name')"/>
        </div>
        <div class="">
            <x-lareon::input.label title="{{__('image')}}" for="schema_image"/>
            <x-lareon::input.text text="url" dir="ltr" id="schema_image" name="seo[schema][image]" class="block w-full mb-3" value="{{$value['image'] ?? ''}}" :placeholder="__('leave it empty to read from :title',['title'=>__('featured image')])"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.image')"/>
        </div>
    </div>
    <div class="grid gap-3 md:grid-cols-2 mb-3">
        <div class="">
            <x-lareon::input.label title="{{__('software version')}}" for="schema_softwareVersion"/>
            <x-lareon::input.text id="schema_softwareVersion" name="seo[schema][softwareVersion]" class="block w-full mb-3" value="{{$value['softwareVersion'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.softwareVersion')"/>
        </div>
        <div class="">
            <x-lareon::input.label title="{{__('date published')}}" for="schema_datePublished"/>
            <x-lareon::input.text type="date" dir="ltr" id="schema_datePublished" name="seo[schema][datePublished]" class="block w-full mb-3" value="{{$value['datePublished'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.datePublished')"/>
        </div>
    </div>
    <div class="">
        <x-lareon::input.label title="{{__(':title url',['title'=>__('download')])}}" for="schema_download"/>
        <x-lareon::input.text type="url" dir="ltr" id="schema_download" name="seo[schema][download]" class="block w-full mb-3" value="{{$value['download'] ?? ''}}"/>
        <x-lareon::input.error :messages="$errors->get('seo.schema.download')"/>
    </div>

    <div class="mb-3">
        <x-lareon::input.label title="{{__('description')}}" for="schema_description"/>
        <x-lareon::input.textarea id="schema_description" name="seo[schema][description]" class="block w-full mb-3">{{$value['description'] ?? ''}}</x-lareon::input.textarea>
        <x-lareon::input.error :messages="$errors->get('seo.schema.description')"/>
    </div>
    <div class="mb-3 grid md:grid-cols-2 gap-3">
            <div>
                <x-lareon::input.label :title="__('operating systems')" for="operatingSystem-schema"/>
                <x-lareon::input.text id="operatingSystem-schema" class="block w-full" maxlength="255" :placeholder="__('separate with ,') . ' Windows, macOS, Linux'" name="seo[schema][operatingSystem]" :value="$value['operatingSystem'] ?? ''"/>
            </div>
            <div>
                <x-lareon::input.label :title="__('category')" for="applicationCategory-schema"/>
                <x-lareon::input.select id="applicationCategory-schema" class="block w-full" name="seo[schema][applicationCategory]">
                    @foreach(config('seo.schema-type.pageType.SoftwareApplication.applicationCategory') as $type=>$title)
                        <option value="{{$type}}" {{isset($value['applicationCategory']) && $value['applicationCategory']==$type ? 'selected': ''}}>{{__($title)}}</option>
                    @endforeach
                </x-lareon::input.select>
            </div>
        </div>
    <x-seo::sections.publisher name="seo[schema]" class="block w-full mb-3" :value="$value['publisher'] ?? ''" />

    <x-seo::sections.aggregate-rating name="seo[schema]" class="block w-full mb-3" :value="$value['aggregateRating'] ?? ''" />
</section>
