<?php

namespace Lareon\Modules\Comment\App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Lareon\Modules\Comment\App\Models\Comment;

trait HasComment
{
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
