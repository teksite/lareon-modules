<?php

namespace Lareon\Modules\Questionnaire\App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormInboxesExport implements ShouldAutoSize,fromQuery ,WithMapping ,WithHeadings
{
    use Exportable;

    public function __construct(public Builder $query)
    {
    }


    public function map($row): array
    {
        dd($row);
        $dataForm=json_decode($row->data , true);
        return collect($dataForm)->map(function ($item ,$key) {
            if (is_array($item)) return implode(",", $item);
            return $item;
        })->merge(['form title'=>$row->form->title,'url'=>$row->url ,'date'=>$row->created_at])->toArray();

    }
    public function headings(): array
    {
        return $this->query->count() ? $this->query->first()->data->keys()->toArray() : [];
    }

    public function query()
    {
        return  $this->query;
    }
}
