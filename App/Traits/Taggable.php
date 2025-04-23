<?php

namespace Lareon\Modules\Tag\App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Lareon\Modules\Tag\App\Models\Tag;

trait Taggable
{
    use SaveTag;

    /**
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'model', 'tag_models', 'model_id', 'tag_id');
    }
}
