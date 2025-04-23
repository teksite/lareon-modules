@props(['model'])
@php($rand=rand(100,1000))
@if(in_array(config('lareon.comment.allow') ,['auth' ,'any']))
    <form action="{{route('client.submitting.comment')}}" method="POST" class="new_comments formMode">
        @csrf
        <input type="hidden" value="{{encrypt($model->id)}}" name="data_info[identify]"  readonly>
        <input type="hidden" value="{{encrypt(get_class($model))}}" name="data_info[type]"  readonly>
        <input type="hidden" class="hidden" name="data_info[url]" value="{{url()->current()}}" readonly>
        <input type="hidden" class="hidden" name="data_info[fullname]">
        <input type="hidden" class="comment_parent" name="parent" value="">

        @if(config('lareon.comment.allow') === 'any')
            <div class="flex flex-col md:flex-row gap-6 items-center mb-6 ">
                <div class="block w-full">
                    <x-lareon::input.label for="comment_user_name-{{$rand}}" :title="__('nickname')" :required="true"/>
                    <x-lareon::input.text id="comment_user_name-{{$rand}}" type="text" name="name" :value="old('name')" class="w-full block" placeholder="{{__('name')}}" :required="true"/>
                    <x-lareon::input.error :message="get_error($errors , 'name')"/>

                </div>
                <div class="block w-full">
                    <x-lareon::input.label for="comment_user_email-{{$rand}}" :title="__('email')" :required="true"/>
                    <x-lareon::input.text id="comment_user_email-{{$rand}}" dir="ltr" type="email" name="email" :value="old('email')" class="w-full block" placeholder="youremail@example.com" :required="true"/>
                    <x-lareon::input.error :message="get_error($errors , 'email')" :required="true"/>
                </div>
            </div>
        @endif
        <div>
            <x-lareon::input.label for="comment_message-{{$rand}}" :title="__('message')" :required="true" />
            <x-lareon::input.textarea maxlength="600" id="comment_message-{{$rand}}" name="message" class="w-full block" rows="5" :required="true">{{old('message')}}</x-lareon::input.textarea>
            <x-lareon::input.error :message="get_error($errors , 'message')"/>
        </div>
       <div class="mt-6">
           <x-lareon::button.solid type="submit" title="{{__('submit')}}">{{__('submit')}}</x-lareon::button.solid>
       </div>
    </form>
@endif
