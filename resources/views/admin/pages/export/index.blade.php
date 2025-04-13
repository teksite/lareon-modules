<x-lareon::admin-layout>
    <x-lareon::box>
        <form action="{{route('admin.questionnaire.inboxes.export.execute')}}">
            <div class="grid md::grid-cols-2 lg:grid-cols-3 gap-6 items-end">
                <div class="md:col-span-2 lg:col-span-1">
                    <x-lareon::input.label for="form_title" :title="__('form')"/>
                    <x-lareon::input.select name="form" id="form_title" class="block w-full">
                        @foreach($forms as $form)
                            <option value="{{$form->id}}">
                                {{$form->title}}
                            </option>
                        @endforeach
                    </x-lareon::input.select>
                    <x-lareon::input.error :messages="$errors->get('form')" class="mt-2"/>
                </div>
                <div class="">
                    <x-lareon::input.label :title="__('date')"/>
                   <div class="flex items-center gap-3">
                       <div class="flex items-center gap-1">
                           <x-lareon::input.label for="date_start" :title="__('from')"/>
                           <x-lareon::input.text name="date[start]" id="date_start" type="date"/>
                       </div>
                       <div class="flex items-center gap-1">
                           <x-lareon::input.label for="date_end" :title="__('until')"/>
                           <x-lareon::input.text name="date[end]" id="date_end" type="date"/>
                       </div>
                   </div>

                    <x-lareon::input.error :messages="$errors->get('form')" class="mt-2"/>
                    <x-lareon::input.error :messages="$errors->get('until')" class="mt-2"/>
                </div>
                <div class="flex items-center justify-end self-end">
                    <x-lareon::button.solid type="submit" role="button">{{__('export')}}</x-lareon::button.solid>
                </div>
            </div>
        </form>

    </x-lareon::box>
</x-lareon::admin-layout>
