<?php

namespace Lareon\Modules\Comment\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Lareon\Modules\Comment\App\Models\Comment;

class CheckParentCommentRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       $parentComment=Comment::find($value);
       if (!$parentComment || !$parentComment->confirmed)  $fail('wrong comment to reply to');
    }
}
