<?php

namespace Lareon\Modules\Seo\App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Lareon\Modules\Seo\App\Models\SeoSite;

use Spatie\SchemaOrg\GeoCoordinates;
use Spatie\SchemaOrg\PostalAddress;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\SearchAction;
use Spatie\SchemaOrg\WebPage;

class WebsiteGeneratorService
{


    public function generate(): array
    {
        $data = SeoSite::query()->whereIn('key', ['website', 'local_business', 'organization'])->where('state', '1')->select(['key', 'value'])->get();
        $dataModified = [];
        foreach ($data as $item) {
            $dataModified[$item->key] = $item->value->toArray();
        }
        $scripts = [];
        if (isset($dataModified['website'])) {
            $scripts['website'] = $this->generateWebSite($dataModified['website']);
        }
        if (isset($dataModified['local_business'])) {
            $scripts['local_business'] = $this->generateLocalBusiness($dataModified['local_business']);
        }
        if (isset($dataModified['local_business'])) {
            $scripts['local_business'] = $this->generateLocalBusiness($dataModified['local_business']);
        }
        if (isset($dataModified['organization'])) {
            $scripts['organization'] = $this->generateOrganization($dataModified['organization']);
        }
        return $scripts;
    }

    public function generateWebSite($data = []): ?WebPage
    {
        if (!count($data)) return null;
        $website = (new WebPage())->name($data['title'] ?? config('app.name'))
            ->description($data['description'] ?? null)
            ->url(config('app.url'))
            ->if(Route::has('search'), function ($qrt) {
                $qrt->potentialAction((new SearchAction())
                    ->target(route('search') . '?s={search_term_string}')
                    ->setProperty('query-input', "required name=search_term_string"));
            })
            ->inLanguage($data['language'] ?? app()->getLocale() ?? null);

        return $website;

    }

    public function generateLocalBusiness($data = [])
    {
        if (!count($data)) return null;
        $local = Schema::{$this->getLocalBusinessType($data['type'] ?? 'LocalBusiness')}();
        $local
            ->name($data['name'] ?? config('app.name'))
            ->description($data['description'] ?? null)
            ->image($data['image'] ?? null)
            ->identifier($data['id_url'] ?? config('app.url') . '#localBusiness')
            ->url(config('app.url'))
            ->telephone($data['telephone'] ?? null)
            ->priceRange($data['price_range'] ?? null)
            ->address($this->createAddress($data['address'] ?? []))
            ->geo($this->createGeo($data['geo'] ?? []))
            ->sameAs($data['sameas'] ?? null)
            ->openingHoursSpecification($this->createOpeningHour($data['openingHours'] ?? []));

        return $local;


    }

    public function generateOrganization($data = [])
    {
        if (!count($data)) return null;
        $organization = Schema::{$this->getOrganizationType($data['type'] ?? 'LocalBusiness')}();
        $organization = Schema::organization();
        $organization->name($data['name'] ?? config('app.name'))
            ->description($data['description'] ?? null)
            ->alternateName($data['alternate_name'] ?? null)
            ->url(config('app.url'))
            ->logo($data['image'] ?? null)
            ->sameAs($data['sameas'] ?? null)
            ->contactPoint($this->createContactPoint($data['contactPoint'] ?? []));


        return $organization;

    }

    private function getLocalBusinessType(string $type): string
    {
        $localTypes = [];
        foreach (config('seo.schema-type.localBusiness_type') as $key => $value) {
            foreach ($value as $typ) {
                $localTypes[$typ] = $typ;
            }
        }
        return $localTypes[$type] ?? 'LocalBusiness';

    }

    private function getOrganizationType(string $type): string
    {
        $organization = [];
        foreach (config('seo.schema-type.organization_type') as $key => $value) {
            foreach ($value as $typ) {
                $organization[$typ] = $typ;
            }
        }
        return $organization[$type] ?? 'Organization';
    }

    private function createAddress(array $data): ?PostalAddress
    {
        return empty($data) ? null : Schema::postalAddress()
            ->addressCountry($data['country'] ?? null)
            ->addressLocality($data['city'] ?? null)
            ->streetAddress($data['street'] ?? null)
            ->postalCode($data['zip_code'] ?? null);
    }

    private function createGeo(array $data): ?GeoCoordinates
    {
        if (!isset($data['latitude']) || !isset($data['longitude'])) return null;
        return Schema::geoCoordinates()
            ->latitude($data['latitude'])
            ->longitude($data['longitude']);

    }

    private function createOpeningHour(array $data = []): ?array
    {
        $items = [];
        foreach ($data as $day => $time) {
            if (isset($time['start'], $time['end'])) {
                $items[] = Schema::OpeningHoursSpecification()
                    ->dayOfWeek(Str::ucfirst($day))
                    ->opens($time['start'])
                    ->closes($time['end']);
            }
        }
        return count($data) ? $items : null;


    }

    private function createContactPoint(array $data = []): ?array
    {
        if (!count($data)) return null;
        foreach ($data as $contact) {
            $items[] = Schema::ContactPoint()
                ->telephone($contact['telephone'] ?? null)
                ->email($contact['email'] ?? null)
                ->contactType($contact['contactType'] ?? null)
                ->contactOption($contact['contactOption'] ?? null)
                ->areaServed($contact['areaServed'] ?? null)
                ->availableLanguage($contact['availableLanguage'] ?? null);
        }
        return count($items) ? $items : null;
    }

}
