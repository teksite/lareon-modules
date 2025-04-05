@props([ 'name','value'=>[], 'placeholder'=>null, 'required'=>false ,'open'=>false ,'accordion'=>false] )
@php($randomItem=rand(100,9999).\Illuminate\Support\Str::random(6).rand(100,9999))
    <fieldset class="fieldset">
        <legend class="legend">{{__('clip')}}</legend>
        @foreach($value ?? [] as $key=>$item)
            @php($rand=\Illuminate\Support\Str::random(6).rand(100,9999))
            <fieldset class="fieldset dynamicGroup_{{$randomItem}}"  id="clip_{{$rand}}-{{$loop->index}}" x-data="{ removeField() { document.getElementById('clip_{{$rand}}-{{$loop->index}}').remove(); }}">
                <legend>{{__('clip') . ' #' .$loop->iteration }}</legend>
                <div class=" mb-3 flex justify-between items-center gap-6" >
                    <div class="w-full">
                        <x-lareon::input.label :title="__('name')"  for="dynamic_item_clips-{{$rand}}-{{$loop->index}}_name"/>
                        <x-lareon::input.text  name="{{$name}}[clips][{{$loop->index}}][name]"  id="dynamic_item_clips-{{$rand}}-{{$loop->index}}_name" class="block w-full" :value="$item['name'] ?? ''"/>
                    </div>
                    <button type="button" class="text-red-600 deleteItemBtn" data-target="dynamic_item_clips-{{$rand}}-{{$loop->index}}" @dblclick="removeField">
                        &times;
                    </button>
                </div>
               <div class="w-full mb-3 ">
                   <x-lareon::input.label :title="__('description')"  for="dynamic_item_clips-{{$rand}}-{{$loop->index}}_desc"/>
                   <x-lareon::input.textarea  name="{{$name}}[clips][{{$loop->index}}][description]"  id="dynamic_item_clips-{{$rand}}-{{$loop->index}}_desc" class="block w-full">{{$item['description'] ?? ''}}</x-lareon::input.textarea>
               </div>
                <div class="w-full mb-3 ">
                    <x-lareon::input.label :title="__('url')"  for="dynamic_item_clips-{{$rand}}-{{$loop->index}}_url"/>
                    <x-lareon::input.text  name="{{$name}}[clips][{{$loop->index}}][url]"  type="url" dir="ltr" id="dynamic_item_clips-{{$rand}}-{{$loop->index}}_url" class="block w-full" :value="$item['url'] ?? ''"/>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-start gap-3 mb-3">
                    <div class="w-full">
                        <x-lareon::input.label :title="__('start offset') . '(s)'"  for="dynamic_item_clips-{{$rand}}-{{$loop->index}}_startOffset"/>
                        <x-lareon::input.text  name="{{$name}}[clips][{{$loop->index}}][startOffset]"  id="dynamic_item_clips-{{$rand}}-{{$loop->index}}_startOffset" class="block w-full" :value="$item['startOffset'] ?? ''"/>
                    </div>
                    <div class="w-full">
                        <x-lareon::input.label :title="__('end offset')  . '(s)'"  for="dynamic_item_clips-{{$rand}}-{{$loop->index}}_endOffset"/>
                        <x-lareon::input.text  name="{{$name}}[clips][{{$loop->index}}][endOffset]"  id="dynamic_item_clips-{{$rand}}-{{$loop->index}}_endOffset" class="block w-full" :value="$item['endOffset'] ?? ''"/>
                    </div>
                </div>

            </fieldset>
        @endforeach

        <div x-data="function handler(){return { fields: [], addNewField(){this.fields.push({ txt1: '' , txt2: '', txt3: '', txt4: '', txt5: ''});},removeField(index){ this.fields.splice(index, 1);}}}">
            <div class="mt-6">
                <template x-data="{'lngth' : document.querySelectorAll('.dynamicGroup_{{$randomItem}}').length}" x-for="(field, index) in fields" :key="index">
                    <fieldset class="dynamicGroup fieldset" x-bind:id="`dynamicGroup_${index + lngth + 1}`">
                        <legend x-text:="`${index + lngth + 1}`"></legend>
                        <div class="my-3 flex justify-between items-center gap-6">
                            <div class="w-full">
                                <label x-text:="`{{__('name')}}" x-bind:for="`dynamic_new_item_clips-${index + lngth + 1}`"
                                       class="block font-medium text-xs text-gray-600  mb-2">{{__('name')}}</label>
                                <x-lareon::input.text x-bind:id="`dynamic_new_item_clips-${index + lngth + 1}`" class="block w-full" x-model="field.txt1" x-bind:name="`{{$name}}[clips][${index + lngth + 1}][name]`"/>
                            </div>

                            <div>
                                <button type="button" class="text-red-900" @click="removeField(index)">
                                    &times;
                                </button>
                            </div>
                        </div>
                        <div class="w-full">
                            <label x-text:="`{{__('description')}}`" x-bind:for="`dynamic_new_item_clips-${index + lngth + 1}_description`"
                                   class="block font-medium text-xs text-gray-600  mb-2">{{__('new :title',['title'=>__('description')])}}</label>
                            <x-lareon::input.textarea  x-bind:id="`dynamic_new_item_clips-${index + lngth + 1}_description`" class="block w-full" x-model="field.txt2" x-bind:name="`{{$name}}[clips][${index + lngth + 1}][description]`"></x-lareon::input.textarea>
                        </div>
                        <div class="w-full">
                            <label x-text:="`{{__('url ')}}`" x-bind:for="`dynamic_new_item_clips-${index + lngth + 1}_url`"
                                   class="block font-medium text-xs text-gray-600  mb-2">{{__('new :title',['title'=>__('url')])}}</label>
                            <x-lareon::input.text type="url" dir="ltr"  x-bind:id="`dynamic_new_item_clips-${index + lngth + 1}_url`" class="block w-full" x-model="field.txt3" x-bind:name="`{{$name}}[clips][${index + lngth + 1}][url]`"/>
                        </div>

                    <div class="flex flex-col md:flex-row items-center justify-start gap-3 mb-3">
                        <div class="w-full">
                            <label x-text:="`{{__('start offset') . '(s)'}}`" x-bind:for="`dynamic_new_item_clips-${index + lngth + 1}_startOffset`"
                                   class="block font-medium text-xs text-gray-600  mb-2">{{__('start offset') . '(s)'}}</label>
                            <x-lareon::input.text  x-bind:id="`dynamic_new_item_clips-${index + lngth + 1}_startOffset`" class="block w-full" x-model="field.txt4" x-bind:name="`{{$name}}[clips][${index + lngth + 1}][startOffset]`" />
                        </div>
                        <div class="w-full">
                            <label x-text:="`{{__('end offset') . '(s)'}}`" x-bind:for="`dynamic_new_item_clips-${index + lngth + 1}_endOffset`"
                                   class="block font-medium text-xs text-gray-600  mb-2">{{__('end offset') . '(s)'}}</label>
                            <x-lareon::input.text  x-bind:id="`dynamic_new_item_clips-${index + lngth + 1}_endOffset`" class="block w-full" x-model="field.txt5" x-bind:name="`{{$name}}[clips][${index + lngth + 1}][endOffset]`" />
                        </div>

                    </div>
                    </fieldset>
                </template>
                <div class="my-3">
                    <x-lareon::button.solid type="button" role="button" title="{{__('add title')}}" id="addDynamicFAQ" @click="addNewField()">
                        {{__('add')}}
                    </x-lareon::button.solid>

                </div>
            </div>
        </div>
    </fieldset>
