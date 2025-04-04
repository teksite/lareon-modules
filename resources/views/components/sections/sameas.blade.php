@props([ 'name','value'=>[], 'placeholder'=>null, 'required'=>false ,'open'=>false ,'accordion'=>false] )
@php($randomItem=rand(100,9999).\Illuminate\Support\Str::random(6).rand(100,9999))
<x-lareon::accordion.box :open="$open" :accordion="$accordion">
    <div>
        @foreach($value ?? [] as $key=>$item)
            @php($rand=\Illuminate\Support\Str::random(6).rand(100,9999))
            <div class="dynamicGroup_{{$randomItem}}"  id="{{$rand}}-{{$loop->index}}" x-data="{ removeField() { this.$el.parentElement.remove(); }}">
                <div class=" mb-3 flex justify-between items-center gap-6" >
                    <div class="w-full">
                        <x-lareon::input.label :title="__('link') . ' #'. ($loop->iteration)"  for="dynamic_item_sameas-{{$rand}}-{{$loop->index}}"/>
                        <x-lareon::input.text type="url" dir="ltr" name="{{$name}}[sameas][{{$loop->index}}]"  id="dynamic_item_sameas-{{$rand}}-{{$loop->index}}" class="block w-full" :value="$item ?? ''"/>
                    </div>
                    <button type="button" class="text-red-600 deleteItemBtn" data-target="dynamic_item_sameas-{{$rand}}-{{$loop->index}}" @dblclick="removeField">
                        &times;
                    </button>
                </div>
                <x-lareon::input.error :messages="get_error($errors , $name.'[sameas]['.$loop->index.']')" class="my-2"/>
            </div>
        @endforeach

        <div x-data="function handler(){return { fields: [], addNewField(){this.fields.push({ txt1: ''});},removeField(index){ this.fields.splice(index, 1);}}}">
            <div>
                <template x-data="{'lngth' : document.querySelectorAll('.dynamicGroup_{{$randomItem}}').length}" x-for="(field, index) in fields" :key="index">
                    <div class="dynamicGroup" x-bind:id="`dynamicGroup_${index + lngth + 1}`">
                        <div class="my-3 flex justify-between items-center gap-6">
                            <div class="w-full">
                                <label x-text:="`{{__('link')}} #${index + lngth + 1}`" x-bind:for="`dynamic_new_item_sameas-${index + lngth + 1}`"
                                       class="block font-medium text-xs text-gray-600  mb-2">{{__('new :title',['title'=>__('link')])}}</label>
                                <x-lareon::input.text dir="ltr" x-bind:id="`dynamic_new_item_sameas-${index + lngth + 1}`" class="block w-full" x-model="field.txt1" type="url" x-bind:name="`{{$name}}[sameas][${index + lngth + 1}]`"/>
                            </div>
                            <div>
                                <button type="button" class="text-red-900" @click="removeField(index)">
                                    &times;
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="my-3">
                    <x-lareon::button.solid type="button" role="button" title="{{__('add title')}}" id="addDynamicFAQ" @click="addNewField()">
                        {{__('add')}}
                    </x-lareon::button.solid>

                </div>
            </div>
        </div>
    </div>
</x-lareon::accordion.box>
