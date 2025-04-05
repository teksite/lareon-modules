@props(['value'=>[]])
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="VideoObject" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="VideoObject" class="hidden"  type="hidden"/>
   <div  class="mb-3 grid gap-3 md:grid-cols-2">
       <div>
           <x-lareon::input.label title="{{__('name')}}" for="schema_name"/>
           <x-lareon::input.text id="schema_name" name="seo[schema][name]" class="block w-full mb-3" value="{{$value['name'] ?? $value['title'] ?? ''}}"/>
           <x-lareon::input.error :messages="$errors->get('seo.schema.name')"/>
       </div>
       <div>
           <x-lareon::input.label title="{{__('upload date')}}" for="schema_uploadDate"/>
           <x-lareon::input.text dir="ltr" type="date" id="schema_uploadDate" name="seo[schema][uploadDate]" class="block w-full mb-3" value="{{$value['uploadDate'] ?? ''}}"/>
           <x-lareon::input.error :messages="$errors->get('seo.schema.uploadDate')"/>
       </div>
   </div>
    <div  class="mb-3 grid gap-3 md:grid-cols-2">
        <div>
            <x-lareon::input.label title="{{__(':title url' ,['title'=>__('content')])}}" for="schema_contentUrl"/>
            <x-lareon::input.text id="schema_contentUrl" name="seo[schema][contentUrl]" class="block w-full mb-3" value="{{$value['contentUrl'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.contentUrl')"/>
        </div>
        <div>
            <x-lareon::input.label title="{{__(':title url' ,['title'=>__('embed')])}}" for="schema_embedUrl"/>
            <x-lareon::input.text id="schema_embedUrl" name="seo[schema][embedUrl]" class="block w-full mb-3" value="{{$value['embedUrl'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.contentUrl')"/>
        </div>

    </div>
    <div class="mb-3 ">
        <x-lareon::input.label title="{{__('description')}}" for="schema_description"/>
        <x-lareon::input.textarea id="schema_description" name="seo[schema][description]" class="block w-full mb-3">{{$value['description'] ?? ''}}</x-lareon::input.textarea>
        <x-lareon::input.error :messages="$errors->get('seo.schema.description')"/>
    </div>
    <div  class="mb-3 grid gap-3 md:grid-cols-2">
        <div>
            <x-lareon::input.label for="inLanguage" :title="__('language')"/>
            <x-lareon::input.select name="seo[schema][inLanguage]" id="inLanguage" >
                @foreach(config('lang') as $codeLang=>$lang)
                    <option value="{{$codeLang}}"
                        {{(isset($value['inLanguage']) && $value['inLanguage'] == $codeLang ) ? 'selected' : ''}}>
                        {{__($lang)}}
                    </option>
                @endforeach
            </x-lareon::input.select>
            <x-lareon::input.error :messages="get_error($errors , 'seo[schema][inLanguage]')"/>
        </div>
        {{--applicantLocationRequirements--}}
        <div class="">
            <div class="flex items-center gap-3">
                <x-lareon::input.checkbox  id="isFamilyFriendly" name="seo[schema][isFamilyFriendly]" value="1" :checked="isset($value['isFamilyFriendly'])"/>
                <x-lareon::input.label title="{{__('is family friendly')}}" for="isFamilyFriendly" />
            </div>
            <x-lareon::input.error :messages="$errors->get('seo.schema.isFamilyFriendly')"/>
        </div>
    </div>
    <fieldset class="fieldset">
        <legend class="legend">{{__('duration')}}</legend>
        <div  class="mb-3 grid gap-3 md:grid-cols-3">
            <div>
                <x-lareon::input.label title="{{__('minute')}}" for="schema_duration_minute"/>
                <x-lareon::input.text dir="ltr" type=number id="schema_duration_minute" name="seo[schema][duration][minute]" class="block w-full mb-3" value="{{$value['duration']['minute'] ?? ''}}"/>
                <x-lareon::input.error :messages="$errors->get('seo.schema.duration.minute')"/>
            </div>
            <div>
                <x-lareon::input.label title="{{__('second')}}" for="schema_duration_second"/>
                <x-lareon::input.text  dir="ltr" type=number  id="schema_duration_second" name="seo[schema][duration][second]" class="block w-full mb-3" value="{{$value['duration']['second'] ?? ''}}"/>
                <x-lareon::input.error :messages="$errors->get('seo.schema.duration.second')"/>
            </div>
        </div>
    </fieldset>


    <div class="mb-3 ">
        <x-lareon::dynamic.single name="seo[schema][thumbnailUrls]" :title="__('thumbnails')" :value="old('seo.schema.thumbnailUrls') ?? $value['thumbnailUrls']  ?? []"/>
        <x-lareon::input.error  :message="get_error($errors , 'seo[schema][thumbnailUrls]')"/>
        <x-lareon::input.error  :message="get_error($errors , 'seo[schema][thumbnailUrls][*]')"/>
    </div>
    <x-seo::sections.author :value="$value['author'] ?? []" name="seo[schema]"/>
    <x-seo::sections.publisher :value="$value['publisher'] ?? []" name="seo[schema]"/>

    <x-seo::sections.clips :value="$value['clips'] ?? []" name="seo[schema]"/>




</section>
