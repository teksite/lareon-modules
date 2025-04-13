<?php

namespace Lareon\Modules\Seo\App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemaOrg\BreadcrumbList;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\WebPage;

class SchemaGeneratorService
{
    private array $schema;
    private array $meta;
    private array $instance;

    private const SCHEMA_TYPES = [
        'Article' => 'generateArticle',
        'Event' => 'generateEvent',
        'FAQPage' => 'generateFAQ',
        'JobPosition' => 'generateJobPosting',
        'Person' => 'generatePerson',
        'Product' => 'generateProduct',
        'VideoObject' => 'generateVideo',
    ];

    public function __construct(public ?Model $model = null, public array $manualData = [])
    {
        if ($this->model) {
            $data = $this->model->getSeo(['schema', 'meta']);
            $this->schema = $data['schema'];
            $this->meta = $data['meta'];
            $this->instance = array_merge(
                $this->model->toArray(),
                [
                    'path' => $this->model?->path() ?? null,
                    'like' => $this->model?->like ?? null,
                    'breadcrumb' => $this->model?->breadcrumb() ?? null,
                ]
            );
        } elseif(count($manualData)) {
            $this->schema = $manualData['schema'] ?? [];
            $this->meta = $manualData['meta'] ?? [];
            $this->instance = array_merge(
                $manualData,
                [
                    'path' => $manualData['path'] ?? null,
                    'like' => $manualData['like'] ?? null,
                    'breadcrumb' => $manualData['breadcrumb'] ?? [],
                ]
            );
        }
    }

    public function generate()
    {

        $method = self::SCHEMA_TYPES[$this->schema['seo_type']] ?? null;
        if (!$method || !method_exists($this, $method)) return null;

        return [$this->$method(), $this->generateWebPage()];
    }

    private function generateWebPage(): WebPage
    {
        $published_at = $this->instance['published_at'] ?? $this->instance['created_at'] ?? null;

        return Schema::webPage()
            ->name($this->schema['name'] ?? $this->schema['title'] ?? $this->meta['title'] ?? $this->instance['name'] ?? $this->instance['title'])
            ->url($this->instance['path'] ?? url()->current())
            ->description($this->schema['description'] ?? $this->meta['description'] ?? $this->instance['excerpt'])
            ->datePublished($published_at)
            ->dateModified(max($published_at, $this->instance['updated_at'] ?? now()))
            ->breadcrumb($this->createBreadcrumb($this->instance['breadcrumb'] ?? []));
    }

    private function generateArticle()
    {
        $type = $this->schema['type'] ?? 'Article';
        $article = Schema::{$this->getArticleType($type)}();

        $published_at = $this->instance['published_at'] ?? $this->instance['created_at'] ?? null;

        return $article
            ->mainEntityOfPage((new WebPage)->identifier(url()->current()))
            ->headline($this->getTitle())
            ->description($this->getDescription())
            ->datePublished($published_at)
            ->dateModified(max($published_at, $this->instance['updated_at'] ?? now()))
            ->author($this->createPersonOrOrganization($this->schema['author'] ?? []))
            ->publisher($this->createPersonOrOrganization($this->schema['publisher'] ?? []))
            ->image($this->getImage($this->schema['images'] ?? $this->instance['featured_image'] ?? null));
    }

    private function generateEvent(): \Spatie\SchemaOrg\Event
    {
        $event = Schema::event()
            ->name($this->getTitle())
            ->description($this->getDescription())
            ->image($this->getImage($this->schema['images'] ?? $this->instance['featured_image'] ?? null))
            ->eventStatus($this->schema['eventStatus'] ?? null);

        $this->setEventDates($event);
        $this->setEventAttendance($event);

        return $event->performer($this->createPerformer($this->schema['performer'] ?? []));
    }

    private function generateFAQ(): \Spatie\SchemaOrg\FAQPage
    {
        return Schema::fAQPage()->mainEntity(
            array_map(fn($faq) => Schema::question()
                ->name($faq['question'])
                ->acceptedAnswer(Schema::answer()->text(strip_tags($faq['answer']))),
                $this->schema['faq'] ?? []
            )
        );
    }

    private function generateJobPosting(): \Spatie\SchemaOrg\JobPosting
    {
        $job = Schema::jobPosting()
            ->title($this->getTitle())
            ->description($this->getDescription())
            ->industry($this->schema['industry'] ?? null)
            ->employmentType($this->schema['employmentType'] ?? null)
            ->hiringOrganization($this->createPersonOrOrganization($this->schema['company'] ?? []))
            ->datePosted($this->schema['datePosted'] ?? now())
            ->validThrough($this->schema['validThrough'] ?? now()->addMonth())
            ->baseSalary($this->createBaseSalary($this->schema['baseSalary'] ?? []))
            ->image($this->getImage($this->schema['images'] ?? $this->instance['featured_image'] ?? null));

        $this->setJobLocation($job);

        return $job;
    }

    private function generatePerson(): \Spatie\SchemaOrg\Person
    {
        return Schema::person()
            ->name($this->getTitle())
            ->url($this->schema['url'] ?? null)
            ->email($this->schema['email'] ?? null)
            ->image($this->getImage($this->schema['image'] ?? $this->instance['featured_image'] ?? null))
            ->sameAs($this->schema['sameas'] ?? [])
            ->jobTitle($this->schema['position'] ?? null)
            ->worksFor($this->createPersonOrOrganization($this->schema['company'] ?? []));
    }

    private function generateProduct(): \Spatie\SchemaOrg\Product
    {
        $product = Schema::product()
            ->name($this->getTitle())
            ->image($this->getImage($this->schema['image'] ?? $this->instance['featured_image'] ?? null))
            ->description($this->getDescription())
            ->brand(Schema::brand()->name($this->schema['brand'] ?? null))
            ->sku($this->schema['sku'] ?? null)
            ->gtin8($this->schema['gtin8'] ?? null)
            ->gtin13($this->schema['gtin13'] ?? null)
            ->gtin14($this->schema['gtin14'] ?? null)
            ->mpn($this->schema['mpn'] ?? null);

        if (!empty($this->instance['like'])) {
            $product->aggregateRating($this->createAggregateRating($this->instance['like']));
        }

        return $product;
    }

    private function generateVideo(): \Spatie\SchemaOrg\VideoObject
    {
        $video = Schema::videoObject()
            ->name($this->getTitle())
            ->description($this->getDescription())
            ->thumbnail($this->schema['thumbnailUrls'] ?? $this->instance['featured_image'] ?? [])
            ->uploadDate($this->schema['uploadDate'] ?? null)
            ->contentUrl($this->schema['contentUrl'] ?? null)
            ->embedUrl($this->schema['embedUrl'] ?? null)
            ->author($this->createPersonOrOrganization($this->schema['author'] ?? []))
            ->publisher($this->createPersonOrOrganization($this->schema['publisher'] ?? []))
            ->hasPart($this->createClips($this->schema['clips'] ?? []));

        $this->setVideoDuration($video);

        return $video;
    }

    // Helper methods remain unchanged
    private function getTitle(): ?string
    {
        return $this->schema['name'] ?? $this->schema['title'] ?? $this->meta['title'] ?? $this->instance['title'] ?? null;
    }

    private function getDescription(): ?string
    {
        return $this->schema['description'] ?? $this->meta['description'] ?? $this->instance['excerpt'] ?? null;
    }

    private function getImage($data): mixed
    {
        return (is_null($data) || (is_array($data) && empty($data))) ? null : $data;
    }

    private function createPersonOrOrganization(array $data): mixed
    {
        if (empty($data) || !isset($data['name'])) {
            return null;
        }

        $type = $data['type'] ?? 'Organization';
        $entity = $type === 'Person' ? Schema::person() : Schema::organization();

        $entity->name($data['name'])->url($data['url'] ?? null);

        if ($type === 'Organization' && isset($data['logo'])) {
            $entity->image(Schema::imageObject()->url($data['logo']));
            $entity->sameAs($data['sameas'] ?? null);
        }

        return $entity;
    }

    private function setEventDates($event): void
    {
        $dateTime = $this->schema['date_time'] ?? [];
        $timeZone = $dateTime['time_zone'] ?? '+03:30';

        if (isset($dateTime['start_date'])) {
            $event->startDate($dateTime['start_date'] . ($dateTime['start_time'] ? 'T' . $dateTime['start_time'] : '') . $timeZone);
        }
        if (isset($dateTime['end_date'])) {
            $event->endDate($dateTime['end_date'] . ($dateTime['end_time'] ? 'T' . $dateTime['end_time'] : '') . $timeZone);
        }
    }

    private function setEventAttendance($event): void
    {
        $data = $this->schema['location'] ?? [];
        if (empty($data)) {
            return;
        }

        $event->eventAttendanceMode($this->schema['attendance_mode'] ?? 'none')
            ->location([
                Schema::place()->name($data['name'] ?? null)
                    ->address($this->createAddress($data)),
                Schema::virtualLocation()->url($data['url'] ?? null)
            ]);
    }

    private function createAddress(array $data): mixed
    {
        return empty($data) ? null : Schema::postalAddress()
            ->addressCountry($data['country'] ?? null)
            ->addressLocality($data['city'] ?? null)
            ->streetAddress($data['street'] ?? null)
            ->postalCode($data['zip_code'] ?? null);
    }

    private function createPerformer(array $data): mixed
    {
        if (empty($data) || !isset($data['type'], $data['name'])) {
            return null;
        }

        $typeMap = [
            'PerformingGroup' => 'performingGroup',
            'MusicGroup' => 'musicGroup',
            'DanceGroup' => 'danceGroup',
            'TheaterGroup' => 'theaterGroup',
            'Person' => 'person'
        ];

        $type = $typeMap[$data['type']] ?? null;
        return $type ? Schema::{$type}()->name($data['name'])->url($data['url'] ?? null) : null;
    }

    private function setJobLocation($job): void
    {
        $location = $this->schema['location'] ?? [];
        if (isset($location['country'])) {
            $method = isset($this->schema['applicantLocationRequirements']) ? 'applicantLocationRequirements' : 'jobLocation';
            $value = $method === 'applicantLocationRequirements'
                ? Schema::country()->name($location['country'])
                : Schema::place()->address($this->createAddress($location));
            $job->$method($value);
        }
    }

    private function createBaseSalary(array $data): mixed
    {
        return empty($data) ? null : Schema::monetaryAmount()
            ->name($data['unitText'] ?? null)
            ->value(Schema::quantitativeValue()
                ->minValue($data['minValue'] ?? null)
                ->maxValue($data['maxValue'] ?? null)
                ->unitText($data['unit'] ?? null));
    }

    private function createAggregateRating(array $data): \Spatie\SchemaOrg\AggregateRating
    {
        return Schema::aggregateRating()
            ->ratingValue($data['ratingValue'] ?? 0)
            ->ratingCount($data['ratingCount'] ?? 0)
            ->bestRating($data['bestRating'] ?? 5)
            ->worstRating($data['worstRating'] ?? 1);
    }

    private function setVideoDuration($video): void
    {
        $duration = $this->schema['duration'] ?? [];
        if (isset($duration['second']) || isset($duration['minute'])) {
            $second = $duration['second'] ?? 0;
            $time = convertSeconds($second, 'array');
            $video->duration('PT' . ($time['hours'] ?? 0) . 'H' . ($time['minutes'] ?? 0) . 'M' . ($time['seconds'] ?? 0) . 'S');
        }
    }

    private function createClips(array $data): ?array
    {
        if (empty($data)) {
            return null;
        }

        return array_map(fn($clip) => Schema::clip()
            ->name($clip['name'] ?? null)
            ->description($clip['description'] ?? null)
            ->startOffset($clip['startOffset'] ?? null)
            ->endOffset($clip['endOffset'] ?? null),
            $data);
    }

    private function getArticleType(string $type): string
    {
        return match ($type) {
            'BlogPosting' => 'blogPosting',
            'NewsArticle' => 'newsArticle',
            default => 'article'
        };
    }

    private function createBreadcrumb(array $data): ?BreadcrumbList
    {
        if (!count($data)) return null;
        $items = [];
        $i = 0;
        foreach ($data as $name => $url) {
            $items[] = Schema::listItem()
                ->position($i)
                ->name($name)
                ->item($url);
            $i++;
        }
        return count($items) ? Schema::breadcrumbList($items) : null;
    }
}
