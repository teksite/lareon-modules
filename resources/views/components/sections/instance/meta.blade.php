@props(['data'=>[] ])
<section>
    <fieldset class="fieldset">
        <legend class="legend">
            {{__('meta tag')}}
        </legend>
       <div class="mb-6">
           <x-lareon::input.label for="seo[meta][title]" :title="__('meta title')"/>
           <x-lareon::input.text id="seo[meta][title]" type="text" name="seo[meta][title]" :placeholder="__('leave it empty to read from :title',['title'=>__('title')])" :value="old('seo.meta.title') ?? $data['title']  ?? '' "/>

           <div class="mb-6 h-4 w-full bg-neutral-200 text-xs font-bold">
               <div class="h-4 px-3 text-slate-50 text-xs" id="metaTitleIndicator" data-target="seo[meta][title]"></div>
           </div>


           <x-lareon::input.error  :message="get_error($errors , 'seo[meta][title]')"/>
       </div>
        <div class="mb-6">
            <x-lareon::input.label for="seo[meta][description]" :title="__('meta description')"/>
            <x-lareon::input.textarea id="seo[meta][description]"  name="seo[meta][description]" :placeholder="__('write a :title',['title'=>__('description')]) ">{{old('seo.meta.description') ?? $data['description']  ?? ''}}</x-lareon::input.textarea>

            <div class="mb-6 h-4 w-full bg-neutral-200 text-xs font-bold">
                <div class="h-4 px-3 text-slate-50 text-xs" id="metaDescriptionIndicator" data-target="seo[meta][description]"></div>
            </div>

            <x-lareon::input.error  :message="get_error($errors , 'seo[meta][description]')"/>

        </div>
        <div class="mb-6">
            <x-lareon::input.label for="seo[meta][keywords]" :title="__('meta keywords')"/>
            <x-lareon::input.text id="seo[meta][keywords]" type="text" name="seo[meta][keywords]" :placeholder="__('write :title',['title'=>__('keywords')])  .' ('. __('separate with ,') . ')'" :value="old('seo.meta.keywords') ?? implode(',',$data['keywords']??[]) ??  ''"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[meta][keywords]')"/>

        </div>
        <div class="mb-6">
            <x-lareon::input.label for="seo[meta][conical_url]" :title="__('meta conical url')"/>
            <x-lareon::input.text dir="ltr" type="url" id="seo[meta][conical_url]"  name="seo[meta][conical_url]" :placeholder="__('write :title',['title'=>__('conical url')]) " :value="old('seo.meta.conical_url') ?? $data['conical_url'] ?? ''" />
            <x-lareon::input.error  :message="get_error($errors , 'seo[meta][conical_url]')"/>

        </div>
        <div class="mb-6 flex items-center justify-start gap-3">
            <x-lareon::input.checkbox  id="seo[meta][indexable]"  name="seo[meta][indexable]" value="1" :checked="old('seo.meta.indexable') ==1 || isset($data['indexable']) && $data['indexable']==='index'" />
            <x-lareon::input.label for="seo[meta][indexable]" :title="__('can be crawled by search engines')"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[meta][indexable]')"/>

        </div>
        <div class="mb-6 flex items-center justify-start gap-3">
            <x-lareon::input.checkbox  id="seo[meta][followable]"  name="seo[meta][followable]" value="1" :checked="old('seo.meta.followable')==1 || isset($data['followable']) && $data['followable']==='follow'" />
            <x-lareon::input.label for="seo[meta][followable]" :title="__('can be followed by search engines')"/>
            <x-lareon::input.error  :message="get_error($errors , 'seo[meta][followable]')"/>

        </div>
    </fieldset>
</section>
