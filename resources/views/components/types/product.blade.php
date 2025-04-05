@props(['value'=>[]])
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="Product" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="Product" class="hidden"  type="hidden"/>
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
    <div class="mb-3">
        <x-lareon::input.label title="{{__('description')}}" for="schema_description"/>
        <x-lareon::input.textarea id="schema_description" name="seo[schema][description]" class="block w-full mb-3">{{$value['description'] ?? ''}}</x-lareon::input.textarea>
        <x-lareon::input.error :messages="$errors->get('seo.schema.description')"/>
    </div>
    <div class="">
        <x-lareon::input.label title="{{__('brand')}}" for="schema_brand"/>
        <x-lareon::input.text id="schema_brand" name="seo[schema][brand]" class="block w-full mb-3" value="{{$value['brand'] ?? ''}}" />
        <x-lareon::input.error :messages="$errors->get('seo.schema.brand')"/>
    </div>

    <fieldset class="fieldset mb-3">
        <legend class="legend">{{__('id properties')}}</legend>
        <div class="grid gap-3 md:grid-cols-2">
            <div class="">
                <x-lareon::input.label title="{{__('sku')}}" for="schema_sku"/>
                <x-lareon::input.text text="url" dir="ltr" id="schema_sku" name="seo[schema][sku]" class="block w-full mb-3" value="{{$value['sku'] ?? ''}}" />
                <x-lareon::input.error :messages="$errors->get('seo.schema.sku')"/>
            </div>
            <div class="">
                <x-lareon::input.label title="{{__('gtin8')}}" for="schema_gtin8"/>
                <x-lareon::input.text text="url" dir="ltr" id="schema_gtin8" name="seo[schema][gtin8]" class="block w-full mb-3" value="{{$value['gtin8'] ?? ''}}" />
                <x-lareon::input.error :messages="$errors->get('seo.schema.gtin8')"/>
            </div>
            <div class="">
                <x-lareon::input.label title="{{__('gtin13')}}" for="schema_gtin13"/>
                <x-lareon::input.text text="url" dir="ltr" id="schema_gtin13" name="seo[schema][gtin13]" class="block w-full mb-3" value="{{$value['gtin13'] ?? ''}}" />
                <x-lareon::input.error :messages="$errors->get('seo.schema.gtin13')"/>
            </div>
            <div class="">
                <x-lareon::input.label title="{{__('gtin14')}}" for="schema_gtin14"/>
                <x-lareon::input.text text="url" dir="ltr" id="schema_gtin14" name="seo[schema][gtin14]" class="block w-full mb-3" value="{{$value['gtin14'] ?? ''}}" />
                <x-lareon::input.error :messages="$errors->get('seo.schema.gtin14')"/>
            </div>
            <div class="">
                <x-lareon::input.label title="{{__('mpn')}}" for="schema_mpn"/>
                <x-lareon::input.text text="url" dir="ltr" id="schema_mpn" name="seo[schema][mpn]" class="block w-full mb-3" value="{{$value['mpn'] ?? ''}}" />
                <x-lareon::input.error :messages="$errors->get('seo.schema.mpn')"/>
            </div>
        </div>
    </fieldset>
    <x-seo::sections.aggregate-rating name="seo[schema]" class="block w-full mb-3" :value="$value['aggregateRating'] ?? ''" />
</section>
