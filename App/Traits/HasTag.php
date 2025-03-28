<?php

namespace Lareon\Modules\Tag\App\Traits;

use Lareon\Modules\Tag\App\Models\Tag;

trait HasTag
{
    use SaveTag;

    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'model', 'tag_models', 'model_id', 'tag_id');
    }
}
