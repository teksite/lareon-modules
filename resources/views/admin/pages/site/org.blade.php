<x-seo::admin-seo-page-layout xmlns:x-lareon="http://www.w3.org/1999/html">
    @section('title', __('local business seo'))
    @section('description', __('a structured data type used to define an organization’s details'))
    @section('form')
        <x-lareon::box class="mb-6">
            <div class="mb-3 flex items-center gap-1">
                <x-lareon::input.checkbox id="state" name="organization[state]" value="1" :checked="old('organization.state' , $data->state ?? false)"/>
                <x-lareon::input.label for="state" :title="__('activate')"/>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <fieldset class="fieldset">
                        <legend class="legend">
                            {{__('information')}}
                        </legend>
                        <table class="w-full">
                            <tbody class="">
                            {{--Type--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="type" :title="__('type')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.select id="type" name="organization[value][type]" :required="true">
                                        @foreach(config('seo.schema-type.organization_type') as $key=>$value)
                                            <optgroup label="{{__($key)}}">
                                                @foreach($value as $typ)
                                                    <option value="{{$typ}}"
                                                        {{(old('organization.value.type') == $typ ||  (isset($data->value['type']) && $data->value['type']==$typ ))? 'selected' :''}}>
                                                        {{__($typ)}}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </x-lareon::input.select>
                                    <x-lareon::input.error :messages="get_error($errors , 'organization[value][currency]')"/>
                                </td>
                            </tr>
                            {{--Title--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="title" :title="__('title')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="title" name="organization[value][title]"
                                                          :value="old('organization.value.title') ?? $data->value['title'] ?? config('app.name') ?? ''"
                                                          :placeholder="__('write a :title',['title'=>__('title')])"
                                                          :required="true"/>
                                    <x-lareon::input.error :messages="get_error($errors , 'organization[value][title]')"/>
                                </td>
                            </tr>
                            {{--Alternative Title--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="alternative_title" :title="__('alternative title')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="alternative_title" name="organization[value][alternative_title]"
                                                          :value="old('organization.value.alternative_title') ?? $data->value['alternative_title'] ?? config('app.name') ?? ''"
                                                          :placeholder="__('write a :title',['title'=>__('title')])"
                                                          :required="true"/>
                                    <x-lareon::input.error :messages="get_error($errors , 'organization[value][alternative_title]')"/>
                                </td>
                            </tr>
                            {{--Desc--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="description" :title="__('description')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.textarea name="organization[value][description]" id="description"
                                                              :placeholder="__('write a :title',['title'=>__('description')])"
                                                              :required="true">{{old('organization.value.description') ?? $data->value['description'] ?? ''}}</x-lareon::input.textarea>
                                    <x-lareon::input.error :messages="get_error($errors , 'organization[value][description]')"/>
                                </td>
                            </tr>
                            {{--Image--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="logo" :title="__('logo')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="logo" name="organization[value][image]" type="url" dir="ltr" :value="old('organization.value.image') ?? $data->value['image'] ?? ''" :placeholder="__(':title url',['title'=>__('logo')])" :required="true"/>
                                    <x-lareon::input.error :messages="get_error($errors , 'organization[value][image]')"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
                <div>
                    <fieldset class="fieldset">
                        <legend class="legend">
                            {{__('social media')}}
                        </legend>
                        <x-seo::sections.sameas name="organization[value]" :value="old('organization.value.sameas') ?? $data->value['sameas'] ?? []" />
                    </fieldset>
                </div>
            </div>
        </x-lareon::box>

        <x-lareon::box class="mb-6">
            <fieldset class="fieldset" >
                <legend class="legend">
                  {{__('contact')}}
                </legend>

                <x-seo::sections.contactPoint name="organization[value]" :value="old('organization.value.contactPoint') ?? $data->value['contactPoint'] ?? []" />

            </fieldset>
        </x-lareon::box>
    @endsection
</x-seo::admin-seo-page-layout>
