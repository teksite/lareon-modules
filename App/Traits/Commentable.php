<?php

namespace Lareon\Modules\Comment\App\Traits;

use Lareon\Modules\Comment\App\Models\Comment;

trait Commentable
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'model');
    }
    public function recursiveComment()
    {
        return $this->MorphedByManyOfDescendants(Comment::class, 'model');
    }

}
