<x-lareon::admin-layout>
    @section('title', __('captcha'))
    @section('description', __('captcha in applications is a security mechanism designed to distinguish between human users and automated bots, usually by presenting challenges that are easy for humans but hard for machines to solve'))

    <div class="grid gap-6 md:grid-cols-2">
        <x-lareon::box>
            <table>
                <tbody>
                <tr>
                    <th class="text-start p-3">
                        {{__('is enabled')}}
                    </th>
                    <td class="p-3">
                        {{config('lareon.captcha.enable',false) ? __('yes') : __('no') }}
                    </td>
                </tr>
                <tr>
                    <th class="text-start p-3">
                        {{__('type')}}
                    </th>
                    <td class="p-3">
                        {{config('lareon.captcha.type') ?? '?'}}
                    </td>
                </tr>
                </tbody>
            </table>
            <hr class="my-6 border-slate-200">
           <ul class="space-y-3 list-disc list-inside">
               <li>
                   <a href="https://www.google.com/recaptcha/admin/create" target="_blank" class="text-blue-600">GOOGLE V2</a>
               </li>
               <li>
                   <a href="https://dash.cloudflare.com/" target="_blank" class="text-blue-600">CLOUDFLARE</a>
               </li>
           </ul>
        </x-lareon::box>
        <x-lareon::box>
            <p class="mb-1 text-sm font-semibold">
                {{__('to enable CAPTCHA and specify its type, modify the configuration file')}}
            </p>
            <p class="mb-1 text-sm font-semibold">
                {{__('to display CAPTCHA in your form, include the following component')}}
            </p>
            <dev class="mb-3 bg-zinc-900 rounded p-3 text-slate-50 block w-full" dir="ltr" style="box-shadow:-5px 0 0 0 green">
                <pre><code class="font-bold">&lt;<span>x-captcha::load </span><span>/</span>&gt;</code></pre>
                <p>{{__('or')}}</p>
                <pre><code class="font-bold"><span>&#x40;</span>captcha</code></pre>
            </dev>
            <p class="mb-1 mt-3 text-sm font-semibold">
                {{__('and to validate it, add the rule below')}}
            </p>
            <dev class="mb-3 bg-zinc-900 rounded p-3 text-slate-50 block w-full" dir="ltr" style="box-shadow:-5px 0 0 0 blue">
                <pre><code class="font-bold">use Lareon\Modules\Captcha\App\Rules\CaptchaRule</code>

                </pre>
                <pre><code class="font-bold">'g-recaptcha-response'=>['required' , new CaptchaRule()]</code></pre>
            </dev>

        </x-lareon::box>
    </div>
</x-lareon::admin-layout>
