@props([ 'name','value'=>[]] )
@php($randomItem=rand(100,9999).\Illuminate\Support\Str::random(6).rand(100,9999))
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="FAQPage" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="FAQPage" class="hidden"  type="hidden"/>
    <div>
       @foreach($value['faq'] ?? [] as $key=>$item)
                @php($rand=\Illuminate\Support\Str::random(6).rand(100,9999))
                <fieldset class="dynamicGroup_{{$randomItem}} mb-6 p-3 border border-slate-300 rounded-lg"  id="dynamic_item_faq-{{$rand}}-{{$loop->index}}" x-data="{ removeField() { document.getElementById('dynamic_item_faq-{{$rand}}-{{$loop->index}}').remove(); }}">
                    <legend>
                        FAQ #{{($loop->iteration)}}
                    </legend>
                    <div class=" mb-3 flex justify-between items-center gap-6" >
                        <div class="w-full">
                            <x-lareon::input.label :title="__('question') . ' #'. ($loop->iteration)"  for="dynamic_item_question-{{$rand}}-{{$loop->index}}"/>
                            <x-lareon::input.text name="seo[schema][faq][{{$loop->index}}][question]" id="dynamic_item_question-{{$rand}}-{{$loop->index}}" class="block w-full" :value="$item['question'] ?? ''" :required="true"/>
                        </div>
                        <button type="button" class="text-red-600 deleteItemBtn" data-target="dynamic_item_faq-{{$rand}}-{{$loop->index}}" @dblclick="removeField">
                            &times;
                        </button>

                    </div>
                    <div class="w-full">
                        <x-lareon::input.label :title="__('answer') . ' #'. ($loop->iteration)"  for="dynamic_item_answer-{{$rand}}-{{$loop->index}}"/>
                        <x-lareon::input.textarea name="seo[schema][faq][{{$loop->index}}][answer]"  id="dynamic_item_answer-{{$rand}}-{{$loop->index}}" class="block w-full" :required="true">{{$item['answer'] ?? ''}}</x-lareon::input.textarea>
                    </div>
                    <x-lareon::input.error :messages="get_error($errors , 'seo[schema][faq]['.$loop->index.'][question]')" class="my-2"/>
                    <x-lareon::input.error :messages="get_error($errors , 'seo[schema][faq]['.$loop->index.'][answer]')" class="my-2"/>
                </fieldset>
            @endforeach

        <div x-data="function handler(){return { fields: [], addNewField(){this.fields.push({ txt1: '',  txt2: ''});},removeField(index){ this.fields.splice(index, 1);}}}">
            <div>
                <template x-data="{'lngth' : document.querySelectorAll('.dynamicGroup_{{$randomItem}}').length}" x-for="(field, index) in fields" :key="index">
                    <fieldset class="dynamicGroup  mb-6 p-3 border border-slate-300 rounded-lg" x-bind:id="`dynamicGroup_${index + lngth + 1}`">
                        <legend x-text:="`FAQ ${index + lngth + 1}`"></legend>
                        <div class="my-3 flex justify-between items-center gap-6">
                            <div class="w-full">
                                <label x-text:="`{{__('question')}} #${index + lngth + 1}`" x-bind:for="`dynamic_new_item_answer-${index + lngth + 1}`"
                                       class="block font-medium text-xs text-gray-600  mb-2">{{__('new :title',['title'=>__('link')])}}</label>
                                <x-lareon::input.text x-bind:id="`dynamic_new_item_answer-${index + lngth + 1}`" class="block w-full" x-model="field.txt1" x-bind:name="`seo[schema][faq][${index + lngth + 1}][question]`" :required="true" />
                            </div>
                            <div>
                                <button type="button" class="text-red-900" @click="removeField(index)">
                                    &times;
                                </button>
                            </div>
                        </div>
                        <div class="w-full">
                            <label x-text:="`{{__('answer')}} #${index + lngth + 1}`" x-bind:for="`dynamic_new_item_question-${index + lngth + 1}`"
                                   class="block font-medium text-xs text-gray-600  mb-2">{{__('new :title',['title'=>__('link')])}}</label>
                            <x-lareon::input.textarea x-bind:id="`dynamic_new_item_question-${index + lngth + 1}`" class="block w-full" x-model="field.txt2" x-bind:name="`seo[schema][faq][${index + lngth + 1}][answer]`" :required="true"></x-lareon::input.textarea>
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
    </div>
</section>
