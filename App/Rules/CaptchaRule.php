<?php

namespace Lareon\Modules\Captcha\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Lareon\Modules\Captcha\App\Services\Facades\Captcha;

class CaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (config('lareon.captcha.enable') && config('lareon.captcha.type') === 'local') {
            if (!$value || !Captcha::check($value)){
                $fail(__('recaptcha validation fails, please try again'));
            }
        }elseif (config('lareon.captcha.enable') && config('lareon.captcha.type') === 'google') {
            try{
                $secret_key = config('lareon.captcha.google_secret_key');
                if (!!$secret_key){
                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => $secret_key,
                        'response' => $value,
                        'remoteip' => request()->ip(),
                    ])->json();
                    $response['success'] ?: $fail('recaptcha validation fails');
                }
                else{
                    throw  new \Exception('error invalidation process');
                }

            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $fail(__('something goes wrong in validating google recaptcha'));
            }
        }
    }
}

