@props(['value'=>[]])
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="Person" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="Person" class="hidden"  type="hidden"/>
    <div class="mb-3">
        <x-lareon::input.label title="{{__('name')}}" for="schema_name"/>
        <x-lareon::input.text id="schema_name" name="seo[schema][name]" class="block w-full mb-3" value="{{$value['name'] ?? $value['title'] ?? ''}}"/>
        <x-lareon::input.error :messages="$errors->get('seo.schema.name')"/>
    </div>
    <div class="mb-3 grid gap-3 md:grid-cols-2">
        <div class="">
            <x-lareon::input.label title="{{__('url')}}" for="schema_url"/>
            <x-lareon::input.text type="url" dir="ltr" id="schema_url" name="seo[schema][url]" class="block w-full mb-3" value="{{$value['url'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.url')"/>
        </div>
        <div class="">
            <x-lareon::input.label title="{{__('image url')}}" for="schema_image"/>
            <x-lareon::input.text type="url" dir="ltr" id="schema_image" name="seo[schema][image]" class="block w-full mb-3" value="{{$value['image'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.image')"/>
        </div>
    </div>
    <div class="mb-3 grid gap-3 md:grid-cols-2">
        <div class="">
            <x-lareon::input.label title="{{__('company')}}" for="schema_company"/>
            <x-lareon::input.text id="schema_company" name="seo[schema][company]" class="block w-full mb-3" value="{{$value['company'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.company')"/>
        </div>
        <div class="">
            <x-lareon::input.label title="{{__('position')}}" for="schema_position"/>
            <x-lareon::input.text id="schema_position" name="seo[schema][position]" class="block w-full mb-3" value="{{$value['position'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.position')"/>
        </div>
    </div>
    <x-seo::sections.sameas name="seo[schema]" :value="old('eo.schema.sameas') ?? $value['sameas'] ?? []" />





</section>
