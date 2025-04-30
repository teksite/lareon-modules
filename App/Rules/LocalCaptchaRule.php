<?php

namespace Lareon\Modules\Captcha\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LocalCaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (config('lareon.captcha.enable')) {
            if (!$value || !captcha_check($value)){
                $fail(__('recaptcha validation fails, please try again'));
            }
        }
    }
}
