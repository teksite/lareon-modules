<form action="{{route('client.submitting.form')}}" method="POST" id="{{uuid_create().rand(10,100)}}">
    @csrf
    <input type="hidden" readonly value="{{encrypt($form->id)}}" name="data_info[identify]">
    <input type="hidden" class="hidden" name="data_info[fullname]">
    <input type="hidden" class="hidden" name="data_info[url]" value="{{url()->current()}}" readonly>
    @if($form->template)
        <div>
            @include("forms.$form->template")
        </div>
    @elseif($form->body)
        <div>
            {!! $form->body !!}
        </div>
    @else
        <div>
            {!! $slot !!}
        </div>
    @endif
    @if(isset($button))
        {!! $button !!}
    @else
        <div class="mt-6">
            <x-lareon::button.solid :title="__('submit')" role="button" type="submit" class="block w-full">
                {{__('submit')}}
            </x-lareon::button.solid>
        </div>
    @endif
    @if ($errors->any())
        @if($form->id == decrypt(old('data_info.identify')))
            <hr class="my-3">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li class="text-red-700 font-bold text-sm">{{ $error }}</li>
                @endforeach
            </ul>
            <hr class="my-3">
        @endif
    @endif
</form>
