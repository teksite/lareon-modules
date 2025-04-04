<x-seo::admin-seo-page-layout xmlns:x-lareon="http://www.w3.org/1999/html">
    @section('title', __('local business seo'))
    @section('description', __('a structured data type that provides details about a local business'))

    @section('form')
        <x-lareon::box>
            <div class="mb-3 flex items-center gap-1">
                <x-lareon::input.checkbox id="state" name="local_business[state]" value="1" :checked="old('local_business.state' , $data->state ?? false)"/>
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
                           {{--Type Local--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="type" :title="__('type')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.select id="type" name="local_business[value][type]" :required="true">
                                       @foreach(config('seo.schema-type.localBusiness_type') as $key=>$value)
                                           <optgroup label="{{__($key)}}">
                                               @foreach($value as $typ)
                                                   <option value="{{$typ}}"
                                                       {{(old('local_business.value.type') == $typ ||  (isset($data->value['type']) && $data->value['type']==$typ ))? 'selected' :''}}>
                                                       {{__($typ)}}
                                                   </option>
                                               @endforeach
                                           </optgroup>
                                       @endforeach
                                   </x-lareon::input.select>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][currency]')"/>
                               </td>
                           </tr>
                           {{--Title--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="title" :title="__('title')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="title" name="local_business[value][title]"
                                                         :value="old('local_business.value.title') ?? $data->value['title'] ?? config('app.name') ?? ''"
                                                         :placeholder="__('write a :title',['title'=>__('title')])"
                                                         :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][title]')"/>
                               </td>
                           </tr>
                           {{--Desc--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="description" :title="__('description')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.textarea name="local_business[value][description]" id="description"
                                                             :placeholder="__('write a :title',['title'=>__('description')])"
                                                             :required="true">{{old('local_business.value.description') ?? $data->value['description'] ?? ''}}</x-lareon::input.textarea>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][description]')"/>
                               </td>
                           </tr>
                           {{--Image--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="logo" :title="__('logo')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="logo" name="local_business[value][image]" type="url" dir="ltr" :value="old('local_business.value.image') ?? $data->value['image'] ?? ''" :placeholder="__(':title url',['title'=>__('logo')])" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][image]')"/>
                               </td>
                           </tr>
                           {{--ID URL--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="id_url" :title="__('ID URL')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="id_url" name="local_business[value][id_url]" type="url" dir="ltr" :value="old('local_business.value.id_url') ?? $data->value['id_url'] ?? ''" :placeholder="__(':title url',['title'=>__('id')])" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][id_url]')"/>
                               </td>
                           </tr>
                           {{--phone--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="telephone" :title="__('telephone')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="telephone" name="local_business[value][telephone]" type="url" dir="ltr" :value="old('local_business.value.telephone') ?? $data->value['telephone'] ?? ''" :placeholder="__('phone')" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][telephone]')"/>
                               </td>
                           </tr>
                           {{--Price range--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="price_range" :title="__('price range')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.select id="price_range" name="local_business[value][price_range]" :required="true">
                                       @foreach(config('seo.price-range') as $key=>$value)
                                           <option value="{{$key}}"
                                               {{(old('local_business.value.price_range') == $key ||  (isset($data->value['price_range']) && $data->value['price_range']==$key ))? 'selected' :''}}>
                                               {{__($value)}}
                                           </option>
                                       @endforeach
                                   </x-lareon::input.select>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][price_range]')"/>
                               </td>
                           </tr>
                           {{--Country--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="country" :title="__('country')"/>
                               </th>

                               <td class="w-full p-1">
                                   <x-lareon::input.select name="local_business[value][address][country]" id="country" :required="true">
                                       @foreach(config('area') as $key=>$value)
                                           <option value="{{$key}}"
                                               {{(old('local_business.value.address.country') == $key ||  (isset($data->value['address']['country']) && $data->value['address']['country']==$key ))? 'selected' :''}}>
                                               {{__($value)}}
                                           </option>
                                       @endforeach
                                   </x-lareon::input.select>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][address][country]')"/>
                               </td>
                           </tr>
                           {{--City--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="city" :title="__('city')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="city" name="local_business[value][address][city]"  :value="old('local_business.value.address.city') ?? $data->value['address']['city'] ?? ''" :placeholder="__('city')" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][address][city]')"/>
                               </td>
                           </tr>
                           {{--Street--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="street" :title="__('street')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="street" name="local_business[value][address][street]"  :value="old('local_business.value.address.street') ?? $data->value['address']['street'] ?? ''" :placeholder="__('street')" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][address][street]')"/>
                               </td>
                           </tr>
                           {{--Zip Code--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="zip_code" :title="__('zip code')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="zip_code" dir="ltr" type="number" name="local_business[value][address][zip_code]"  :value="old('local_business.value.address.zip_code') ?? $data->value['address']['zip_code'] ?? ''" :placeholder="__('zip code')" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][address][zip_code]')"/>
                               </td>
                           </tr>
                           {{--latitude--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="latitude" :title="__('latitude')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="latitude" name="local_business[value][geo][latitude]" type="url" dir="ltr" :value="old('local_business.value.geo.latitude') ?? $data->value['geo']['latitude'] ?? ''" :placeholder="__('latitude')" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][geo][latitude]')"/>
                               </td>
                           </tr>
                           {{--longitude--}}
                           <tr>
                               <th class="w-fit p-1 text-start">
                                   <x-lareon::input.label for="longitude" :title="__('longitude')"/>
                               </th>
                               <td class="w-full p-1">
                                   <x-lareon::input.text id="longitude" name="local_business[value][geo][longitude]" type="url" dir="ltr" :value="old('local_business.value.geo.longitude') ?? $data->value['geo']['longitude'] ?? ''" :placeholder="__('longitude')" :required="true"/>
                                   <x-lareon::input.error :messages="get_error($errors , 'local_business[value][geo][longitude]')"/>
                               </td>
                           </tr>
                           </tbody>
                       </table>
                   </fieldset>
               </div>
              <div>
                    <fieldset class="fieldset">
                        <legend class="legend">
                            {{__('work time')}}
                        </legend>
                        <table class="w-full">
                            <tbody class="">
                            {{--monday--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="monday" :title="__('monday')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="monday" name="local_business[value][openingHours][monday]"
                                                          :value="old('local_business.value.openingHours.monday') ?? $data->value['openingHours']['monday'] ?? ''"
                                                          placeholder="8:00 16:00" />
                                    <x-lareon::input.error :messages="get_error($errors , 'local_business[value][openingHours][monday]')"/>
                                </td>
                            </tr>
                            {{--tuesday--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="tuesday" :title="__('tuesday')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="tuesday" name="local_business[value][openingHours][tuesday]"
                                                          :value="old('local_business.value.openingHours.tuesday') ?? $data->value['openingHours']['tuesday'] ?? ''"
                                                          placeholder="8:00 16:00" />
                                    <x-lareon::input.error :messages="get_error($errors , 'local_business[value][openingHours][tuesday]')"/>
                                </td>
                            </tr>
                            {{--wednesday--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="wednesday" :title="__('wednesday')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="wednesday" name="local_business[value][openingHours][wednesday]"
                                                          :value="old('local_business.value.openingHours.wednesday') ?? $data->value['openingHours']['wednesday'] ?? ''"
                                                          placeholder="8:00 16:00" />
                                    <x-lareon::input.error :messages="get_error($errors , 'local_business[value][openingHours][wednesday]')"/>
                                </td>
                            </tr>
                            {{--thursday--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="thursday" :title="__('thursday')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="thursday" name="local_business[value][openingHours][thursday]"
                                                          :value="old('local_business.value.openingHours.thursday') ?? $data->value['openingHours']['thursday'] ?? ''"
                                                          placeholder="8:00 16:00" />
                                    <x-lareon::input.error :messages="get_error($errors , 'local_business[value][openingHours][thursday]')"/>
                                </td>
                            </tr>
                            {{--friday--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="friday" :title="__('friday')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="friday" name="local_business[value][openingHours][friday]"
                                                          :value="old('local_business.value.openingHours.friday') ?? $data->value['openingHours']['friday'] ?? ''"
                                                          placeholder="8:00 16:00" />
                                    <x-lareon::input.error :messages="get_error($errors , 'local_business[value][openingHours][friday]')"/>
                                </td>
                            </tr>
                            {{--saturday--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="saturday" :title="__('saturday')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="saturday" name="local_business[value][openingHours][saturday]"
                                                          :value="old('local_business.value.openingHours.saturday') ?? $data->value['openingHours']['saturday'] ?? ''"
                                                          placeholder="8:00 16:00" />
                                    <x-lareon::input.error :messages="get_error($errors , 'local_business[value][openingHours][saturday]')"/>
                                </td>
                            </tr>
                            {{--sunday--}}
                            <tr>
                                <th class="w-fit p-1 text-start">
                                    <x-lareon::input.label for="sunday" :title="__('sunday')"/>
                                </th>
                                <td class="w-full p-1">
                                    <x-lareon::input.text id="sunday" name="local_business[value][openingHours][sunday]"
                                                          :value="old('local_business.value.openingHours.sunday') ?? $data->value['openingHours']['sunday'] ?? ''"
                                                          placeholder="8:00 16:00" />
                                    <x-lareon::input.error :messages="get_error($errors , 'local_business[value][openingHours][sunday]')"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="legend">
                            {{__('social media')}}
                        </legend>
                      <x-seo::sections.sameas name="local_business[value]" :value="old('local_business.value.sameas') ?? $data->value['sameas'] ?? []" />
                    </fieldset>
                </div>
           </div>

        </x-lareon::box>
    @endsection
</x-seo::admin-seo-page-layout>
