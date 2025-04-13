<?php

namespace Lareon\Modules\Seo\App\Listeners;

use Illuminate\Support\Arr;
use Lareon\CMS\App\Events\CreateOrUpdateInstanceEvent;
use Lareon\Modules\Seo\App\Interfaces\HasSeo;

class CreateOrUpdateSeoInstanceListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(CreateOrUpdateInstanceEvent $event): void
    {
        $instance = $event->instance;
        $data = $event->data;
        $type = $event->type->value;
        if ($instance instanceof HasSeo && in_array($type, ['create', 'update'])) {
            $this->addToSeoModel($event->instance, Arr::except($data['seo'], ['sitemap']));

        } elseif ($instance instanceof HasSeo && in_array($type, ['delete'])) {
            $this->removeFromSeo($instance);
        }
    }

    private function addToSeoModel($instance, $data): void
    {
        //remove and restore instances have soft delete

        $instance->seo()->updateOrCreate(
            [
                "model_type" => get_class($instance),
                "model_id" => $instance->id
            ],
            [
                'title' => $data['meta']['title'] ?? $instance->title ?? $instance->name,
                'description' => $data['meta']['description'] ?? null,
                'conical_url' => $data['meta']['conical_url'] ?? $instance->path(),
                'indexable' => isset($data['meta']['indexable']) ? 'index' : 'noindex',
                'followable' => isset($data['meta']['followable']) ? 'follow' : 'nofollow',
                'keywords' => exploding($data['meta']['keywords'] ?? '')->toArray(),

                'seo_type' => $data['schema']['type'] ?? 'webPag',
                'schema' => $data['schema'] ?? [],
            ]
        );
    }

    private function removeFromSeo($instance): void
    {
        $instance->seo()->delete();
    }
}
