@php
    $rand='img_captcha_'.rand(123,987)
@endphp
<div class="">
    <div class="inline-flex items-stretch bg-white border border-slate-200 rounded-lg overflow-hidden">
        <input type="text" name="g-recaptcha-response" id="captcha-code" class="focus:outline-none px-1 w-full !text-black" required>
        <label for="captcha-code" class="min-w-fit"></label>
            <img id="{{$rand}}" src="{!! \Lareon\Modules\Captcha\App\Services\Facades\Captcha::src('custom') !!}" alt="captcha code" class="recaptcha-image h-full min-h-full w-auto" width="120" height="36">
        <button aria-label="{{__('new captcha code')}}" type="button" role="button" class="py-1 px-3 reload-captcha-btn transition-all duration-300 ease-in-out outline-none focus:outline-none" data-target="{{$rand}}" title="{{__('reload')}}">
            <i class="tkicon recaptchaReloadIcon fill-none stroke-sky-600 stroke-2" id="recaptchaReloadIcon" data-icon="reload" size="16"></i>
        </button>
    </div>
    @props(['messages'=>null])
    @if ($errors->get('g-recaptcha-response'))
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-1']) }}>
            @foreach ((array) $messages as $message)
                @if($message)
                    @foreach ((array) $message as $msg)
                        {{$msg}}
                    @endforeach
                @else
                    {{$message}}
                @endif
            @endforeach
        </ul>
    @endif
</div>
@push('footerScripts')
    @vite(['Modules/Captcha/resources/assets/js/app.js'])
@endpush
