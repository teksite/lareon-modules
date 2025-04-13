@props(['data'=>[]])
<section>
    <fieldset class="fieldset">
        <legend class="legend">
            {{__('schema')}}
        </legend>
        <div class="mb-6">
            <x-lareon::input.label for="seo_type" :title="__('schema type')"/>
            <x-lareon::input.select id="seo_type" class="block w-full">
                @foreach(config('seo.schema-type.pageType') as $type=>$specificType)
                    <option @selected(isset($data['seo_type']) && $data['seo_type'] === $type) >
                        {{$type}}
                    </option>
                @endforeach
            </x-lareon::input.select>
        </div>
        <hr class="my-6  border-y border-slate-600">
        <div id="waitEl"></div>
        <div id="schemaDetails"></div>
    </fieldset>
</section>


