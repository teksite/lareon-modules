<x-lareon::admin-layout>
    <x-lareon::box>
        <form action="{{route('admin.questionnaire.inboxes.export.execute')}}">
            <div class="grid md:grid-cols-2 gap-6 items-end">
                <div>
                    <x-lareon::input.label for="form_title" :value="__('form')"/>
                    <x-lareon::input.select name="form" id="form_title" class="block w-full">
                        @foreach($forms as $form)
                            <option value="{{$form->id}}">
                                {{$form->title}}
                            </option>
                        @endforeach
                    </x-lareon::input.select>
                    <x-lareon::input.error :messages="$errors->get('form')" class="mt-2"/>
                </div>
                <div class="flex items-center gap-3">
                    <x-lareon::input.label :value="__('date')"/>
                    <div class="flex items-center gap-1">
                        <x-lareon::input.label for="date_start" :value="__('from')"/>
                        <x-lareon::input.date name="date[start]" id="date_start" type="date"/>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-lareon::input.label for="date_end" :value="__('until')"/>
                        <x-lareon::input.date name="date[end]" id="date_end" type="date"/>
                    </div>

                    <x-lareon::input.error :messages="$errors->get('form')" class="mt-2"/>
                </div>

            </div>
            <div class="flex items-center justify-end self-end">
                <x-lareon::button.solid type="submit" role="button">{{__('export')}}</x-lareon::button.solid>
            </div>

        </form>

    </x-lareon::box>
</x-lareon::admin-layout>
