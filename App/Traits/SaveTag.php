<?php

namespace Lareon\Modules\Tag\App\Traits;

use Illuminate\Support\Collection;
use Lareon\Modules\Tag\App\Models\Tag;
trait SaveTag
{
    /**
     * Assign tags to the model, syncing them efficiently.
     * if $tags is null it detaches all tags from the instance.
     *
     * @param array|Collection|string|null $tags
     * @return void
     */
    public function assignTags(mixed $tags = null): void
    {
        if (is_null($tags)) {
            $this->tags()->detach();
            return;
        }

        $tags = $this->normalizeTags($tags);

        $this->syncTags($tags);
    }

    /**
     * Normalize input tags into a Collection.
     *
     * @param mixed $tags
     * @return Collection
     */
    private function normalizeTags(mixed $tags): Collection
    {
        return match (true) {
            $tags instanceof Collection => $tags,
            is_array($tags) => collect($tags),
            is_string($tags) => collect([$tags]),
            default => collect([]),
        };
    }

    /**
     * Sync tags by upserting and attaching in an optimized way.
     *
     * @param Collection $tags
     * @return void
     */
    private function syncTags(Collection $tags): void
    {
        if ($tags->isEmpty()) {
            $this->tags()->detach();
            return;
        }

        // Use upsert to create or retrieve tags in one query
        $tagIds = Tag::query()->upsert(
            $tags->map(fn($tag) => ['title' => $tag])->all(),
            ['title'], // Unique key
            ['title']  // Fields to update (none in this case, but required by upsert)
        );

        // Fetch IDs of the upserted/existing tags
        $savedTagIds = Tag::whereIn('title', $tags)->pluck('id')->all();

        // Sync the tags to the relationship
        $this->tags()->sync($savedTagIds);
    }
}
