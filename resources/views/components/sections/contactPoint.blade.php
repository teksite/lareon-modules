@props([ 'name','value'=>[], 'placeholder'=>null, 'required'=>false ,'open'=>false ,'accordion'=>false] )
@php($randomItem=rand(100,9999).\Illuminate\Support\Str::random(6).rand(100,9999))
<x-lareon::accordion.box :open="$open" :accordion="$accordion">
    <div>
            <div id="seoSettingCorporationContactTable">
            @foreach($value ?? [] as $contact )
                <div id="contactItem-{{$loop->index}}" class="p-1 contactItem mb-6 border border-slate-200">
                    <div class="mb-3 gap-3 flex items-center">
                            <div class="w-full">
                                <div>
                                    <x-lareon::input.label title="{{__('telephone')}}"/>
                                    <x-lareon::input.text class="block w-full" name="{{$name}}[contactPoint][{{$loop->index}}][telephone]"
                                                          :value="$contact['telephone'] ?? ''"/>
                                </div>
                            </div>
                            <div class="w-full">
                                <div>
                                    <x-lareon::input.label title="{{__('email')}}"/>
                                    <x-lareon::input.text class="block w-full"
                                                          name="{{$name}}[contactPoint][{{$loop->index}}][email]"
                                                          :value="$contact['email'] ?? ''"/>
                                </div>
                            </div>
                            <div class="w-full">
                                <div>
                                    <x-lareon::input.label title="{{__('type')}}"/>
                                    <x-lareon::input.select class="block w-full"
                                                            name="{{$name}}[contactPoint][{{$loop->index}}][contactType]">
                                        @foreach(config('seo.schema-type.contact_type') as $type)
                                            <option
                                                value="{{$type}}" {{$contact['contactType'] == $type ? 'selected':''}}
                                            >{{__($type)}}</option>
                                        @endforeach
                                    </x-lareon::input.select>

                                </div>
                            </div>
                        </div>
                    <div class="mb-3 gap-3 flex items-center">
                            <div class="w-full">
                                <div>
                                    <x-lareon::input.label title="{{__('options')}}"/>
                                    <x-lareon::input.select class="block w-full" multiple
                                                            name="{{$name}}[contactPoint][{{$loop->index}}][contactOption][]">
                                        @foreach(config('seo.schema-type.contactOption') as $option)
                                            <option value="{{$option}}"
                                                {{(isset($contact['contactOption']) && in_array($option,$contact['contactOption'])) ? 'selected' :''}}
                                            >{{__($option)}}</option>
                                        @endforeach
                                    </x-lareon::input.select>

                                </div>
                            </div>

                            <div class="w-full">
                                <div>
                                    <x-lareon::input.label title="{{__('available language')}}"/>
                                    <x-lareon::input.select class="block w-full" multiple
                                                            name="{{$name}}[contactPoint][{{$loop->index}}][availableLanguage][]">
                                        @foreach(config('lang') as $lang=>$lg)
                                            <option value="{{$lang}}"
                                                {{(isset($contact['availableLanguage']) && in_array($lang,$contact['availableLanguage'])) ? 'selected' :''}}
                                            >{{__($lg)}}</option>
                                        @endforeach
                                    </x-lareon::input.select>

                                </div>
                            </div>
                            <div class="w-full">
                                <div>
                                    <x-lareon::input.label title="{{__('area served')}}"/>
                                    <x-lareon::input.select class="block w-full" multiple name="{{$name}}[contactPoint][{{$loop->index}}][areaServed][]">
                                        @foreach(config('area') as $area=>$country)
                                            <option value="{{$area}}"
                                                {{(isset($contact['areaServed']) && in_array($area,$contact['areaServed'])) ? 'selected' :''}}
                                            >{{__($country)}}</option>
                                        @endforeach
                                    </x-lareon::input.select>

                                </div>
                            </div>
                        </div>
                    <div>
                            <x-lareon::button.solid color="red" onclick="document.getElementById('contactItem-{{$loop->index}}').remove()" role="button" type="button" class="text-xs !p-1 deleteItemBtn" target="contactItem-{{$loop->index}}">
                                {{__('delete')}}
                            </x-lareon::button.solid>
                        </div>
                </div>
            @endforeach
            </div>

        <div x-data="function handler() { return {
        fields: [],
            addNewField() { this.fields.push({  txt1: '', txt2: '', txt3: '', txt4: '', txt5: '', txt6: '' }); },
            removeField(index) { this.fields.splice(index, 1); } }}">
            <div>
                <template x-data="{'lngth' : document.querySelectorAll('.contactItem').length}" x-for="(field, index) in fields" :key="index">
                    <div class="p-1 contactItem mb-6 border border-slate-200" x-bind:id="`contact-${index + lngth + 1}`">
                        <div class="grid gap-3 md:grid-cols-3 my-3">
                            <div>
                                <x-lareon::input.label title="{{__('telephone')}}" x-bind:for="`contact-telephone-${index + lngth + 1}`"/>
                                <x-lareon::input.text x-bind:id="`contact-telephone-${index + lngth + 1}`" class="block mt-1 w-full" x-model="field.txt1" type="text" x-bind:name="`{{$name}}[contactPoint][${index + lngth + 1}][telephone]`"/>
                            </div>
                            <div>
                                <x-lareon::input.label title="{{__('email')}}" x-bind:for="`contact-email-${index + lngth + 1}`"/>
                                <x-lareon::input.text x-bind:id="`contact-email-${index + lngth + 1}`"
                                                      class="block mt-1 w-full"
                                                      x-model="field.txt2"
                                                      type="email" dir="ltr"
                                                      x-bind:name="`{{$name}}[contactPoint][${index + lngth + 1}][email]`"/>
                            </div>
                            <div>
                                <x-lareon::input.label title="{{__('contact type')}}"
                                                       x-bind:for="`contact-type-${index + lngth + 1}`"/>
                                <x-lareon::input.select x-bind:id="`contact-type-${index + lngth + 1}`"
                                                        class="block mt-1 w-full"
                                                        x-model="field.txt3"
                                                        x-bind:name="`{{$name}}[contactPoint][${index + lngth + 1}][contactType]`">
                                    @foreach(config('seo.schema-type.contact_type') as $type)
                                        <option value="{{$type}}">{{__($type)}}</option>
                                    @endforeach
                                </x-lareon::input.select>
                            </div>
                        </div>
                        <div class="grid gap-3 md:grid-cols-3 my-3">
                            <div>
                                <x-lareon::input.label title="{{__('contact option')}}"
                                                       x-bind:for="`contact-option-${index + lngth + 1}`"/>
                                <x-lareon::input.select x-bind:id="`contact-option-${index + lngth + 1}`" multiple
                                                        class="block mt-1 w-full select-box-no-creation"
                                                        x-model="field.txt4"
                                                        x-bind:name="`{{$name}}[contactPoint][${index + lngth + 1}][contactOption][]`">
                                    @foreach(config('seo.schema-type.contactOption') as $type)
                                        <option value="{{$type}}">{{__($type)}}</option>
                                    @endforeach
                                </x-lareon::input.select>
                            </div>
                            <div>
                                <x-lareon::input.label title="{{__('available language')}}"
                                                       x-bind:for="`contact-language-${index + lngth + 1}`"/>
                                <x-lareon::input.select x-bind:id="`contact-language-${index + lngth + 1}`" multiple
                                                        class="block mt-1 w-full select-box-no-creation"
                                                        x-model="field.txt5"
                                                        x-bind:name="`{{$name}}[contactPoint][${index + lngth + 1}][availableLanguage][]`">
                                    @foreach(config('lang') as $lang=>$lg)
                                        <option value="{{$lang}}">{{__($lg)}}</option>
                                    @endforeach
                                </x-lareon::input.select>
                            </div>
                            <div>
                                <x-lareon::input.label title="{{__(' area served')}}"
                                                       x-bind:for="`contact-area-${index + lngth + 1}`"/>
                                <x-lareon::input.select x-bind:id="`contact-area-${index + lngth + 1}`" multiple
                                                        class="block mt-1 w-full select-box-no-creation"
                                                        x-model="field.txt6"
                                                        x-bind:name="`{{$name}}[contactPoint][${index + lngth + 1}][areaServed][]`">
                                    @foreach(config('area') as $area=>$country)
                                        <option value="{{$area}}">{{__($country)}}</option>
                                    @endforeach
                                </x-lareon::input.select>
                                <x-lareon::input.error :messages="$errors->get('web.contacts.*.*.areaServed')"
                                                       class="mt-2"/>
                            </div>
                        </div>
                        <div>
                            <x-lareon::button.solid color="red" type="button text-xs !p-1 " @click="removeField(index)">
                                {{__('delete')}}
                            </x-lareon::button.solid>
                        </div>
                    </div>
                </template>
                <div class="mt-6">
                    <x-lareon::button.solid color="blue" type="button" role="button" title="{{__('add question')}}" id="addQuestion" @click="addNewField()">
                        {{__('add')}}
                    </x-lareon::button.solid>

                </div>
            </div>
        </div>
    </div>
</x-lareon::accordion.box>
