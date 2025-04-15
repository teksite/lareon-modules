<?php

namespace Lareon\Modules\Questionnaire\App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormInboxesExport implements ShouldAutoSize, fromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct(public Builder $query)
    {
    }


    public function map($row): array
    {
        $dataForm = $row->data;
        return collect($dataForm)->map(function ($item) {
            return is_array($item) ? implode(",", $item) : $item;
        })->merge(['form title' => $row->form->title, 'url' => $row->url, 'created at' => $row->created_at, 'ip' => $row->ip_address])
            ->toArray();
    }

    public function headings(): array
    {
        return $this->query->count() ? $this->query->first()->data->keys()->toArray() : [];
    }

    public function query(): Builder
    {
        return $this->query;
    }
}
