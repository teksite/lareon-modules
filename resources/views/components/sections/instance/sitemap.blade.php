@props(['data'=>[]])
<section>
    <fieldset class="fieldset">
        <legend class="legend">
            {{__('sitemap')}}
        </legend>
        <div class="mb-6 flex items-center gap-3">
            <x-lareon::input.label for="seo[sitemap][priority]" :title="__('priority')"/>
            <x-lareon::input.text id="seo[sitemap][priority]" type="number" min="0.1" max="1" step="0.1" name="seo[sitemap][priority]" :value="old('seo.sitemap.priority') ?? $data['priority'] ?? '0.5'"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[sitemap][priority]')"/>
        </div>
        <div class="mb-6 flex items-center gap-3">
            <x-lareon::input.label for="seo[sitemap][changefreq]" :title="__('change frequency')"/>
            <x-lareon::input.select id="seo[sitemap][changefreq]"  name="seo[sitemap][changefreq]">
                @foreach(\Lareon\Modules\Seo\App\Enums\ChangeFreqEnum::cases() as $time)
                    <option value="{{$time->value}}" {{old('seo.sitemap.changefreq' === $time->value) || (isset($data['changefreq']) && $data['changefreq'] === $time->value) ? 'selected' : ''}}>
                        {{__($time->value)}}
                    </option>
                @endforeach
            </x-lareon::input.select>
            <x-lareon::input.error  :message="get_error($errors , 'seo[sitemap][changefreq]')"/>
        </div>
        <div class="mb-6">
            <x-lareon::dynamic.single name="seo[sitemap][images]" :title="__('images')" :value="old('seo.sitemap.images') ?? $data['image']  ?? []"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[sitemap][images]')"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[sitemap][images][*]')"/>
        </div>
        <div class="mb-6">
            <x-lareon::dynamic.single name="seo[sitemap][videos]" :title="__('videos')" :value="old('seo.sitemap.videos') ?? $data['video']  ?? []"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[sitemap][videos]')"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[sitemap][videos][*]')"/>
        </div>

    </fieldset>
</section>
