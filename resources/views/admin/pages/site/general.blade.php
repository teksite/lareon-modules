<x-seo::admin-seo-page-layout xmlns:x-lareon="http://www.w3.org/1999/html">
    @section('title', __('website seo'))
    @section('description', __('website is a structured data markup that provides search engines with general information about a website'))

    @section('form')
        <x-lareon::box>
            <div class="mb-3 flex items-center gap-3">
                <x-lareon::input.checkbox id="state" name="website[state]" value="1"
                                          :checked="old('website.state' , $data->state ?? false)"/>
                <x-lareon::input.label for="state" :title="__('activate')"/>
            </div>
            <fieldset class="fieldset">
                <legend class="legend">
                    {{__('information')}}
                </legend>
                <table class="w-full">
                    <tbody class="">
                    {{--Title--}}
                    <tr>
                        <th class="w-fit p-3 text-start">
                            <x-lareon::input.label for="title" :title="__('title')"/>
                        </th>
                        <td class="w-full p-3">
                            <x-lareon::input.text id="title" name="website[value][title]"
                                                  :value="old('title') ?? $data->value['title'] ?? config('app.name') ?? ''"
                                                  :placeholder="__('write a :title',['title'=>__('title')])"
                                                  :required="true"/>
                            <x-lareon::input.error :messages="get_error($errors , 'website[value][title]')"/>
                        </td>
                    </tr>
                    {{--Desc--}}
                    <tr>
                        <th class="w-fit p-3 text-start">
                            <x-lareon::input.label for="description" :title="__('description')"/>
                        </th>
                        <td class="w-full p-3">
                            <x-lareon::input.textarea name="website[value][description]" id="description"
                                                      :placeholder="__('write a :title',['title'=>__('description')])"
                                                      :required="true">{{old('description') ?? $data->value['description'] ?? ''}}</x-lareon::input.textarea>
                            <x-lareon::input.error :messages="get_error($errors , 'website[value][description]')"/>
                        </td>
                    </tr>
                    {{--Lang--}}
                    <tr>
                        <th class="w-fit p-3 text-start">
                            <x-lareon::input.label for="language" :title="__('language')"/>
                        </th>
                        <td class="w-full p-3">
                            <x-lareon::input.select name="website[value][language]" id="language" :required="true">
                                @foreach(config('lang') as $codeLang=>$lang)
                                    <option value="{{$codeLang}}"
                                        {{(old('website.language' == $codeLang) ||  (isset($data->value['language']) && $data->value['language'] == $codeLang ) ) ? 'selected' : ''}}>
                                        {{__($lang)}}
                                    </option>
                                @endforeach
                            </x-lareon::input.select>
                            <x-lareon::input.error :messages="get_error($errors , 'website[value][language]')"/>
                        </td>
                    </tr>
                    {{--Currency--}}
                    <tr>
                        <th class="w-fit p-3 text-start">
                            <x-lareon::input.label for="currency" :title="__('currency')"/>
                        </th>
                        <td class="w-full p-3">
                            <x-lareon::input.select id="currency" name="website[value][currency]" :required="true">
                                @foreach(config('currency') as $codeCurrency=>$currency)
                                    <option value="{{$codeCurrency}}"
                                        {{(old('website.currency' == $codeCurrency) || (isset($data->value['currency']) && $data->value['currency'] == $codeCurrency )) ? 'selected' : ''}}>
                                        {{__($currency)}}
                                    </option>
                                @endforeach
                            </x-lareon::input.select>
                            <x-lareon::input.error :messages="get_error($errors , 'website[value][currency]')"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
        </x-lareon::box>
    @endsection
</x-seo::admin-seo-page-layout>
