<?php

namespace Lareon\Modules\Tag\App\Traits;

use Illuminate\Support\Collection;
use Lareon\Modules\Tag\App\Models\Tag;

trait SaveTag
{

    public function saveTags(array|Collection|string|null $tags = null): void
    {
        if (is_null($tags)){
            $this->tags()->detach();
            return;
        }

        if (is_array($tags)) $tags = collect($tags);
        if (is_string($tags)) $tags = collect([$tags]);

        $savedTags = $this->saveOrCreateTags($tags);

        $this->tags()->sync($savedTags->pluck('id')->toArray());
    }

    protected function saveOrCreateTags(Collection $tags): Collection
    {
        return $tags->map(fn($item) => Tag::query()->firstOrCreate(['title' => $item]));
    }

}
