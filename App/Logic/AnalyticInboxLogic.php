<?php

namespace Lareon\Modules\Questionnaire\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Lareon\Modules\Questionnaire\App\Models\Form;
use Teksite\Handler\Actions\ServiceWrapper;

class AnalyticInboxLogic
{

    public function generate($startDate, $endDate, $range)
    {
        return app(ServiceWrapper::class)(function () use ($startDate, $endDate, $range) {

            $forms = Form::all();

            [$startDate, $endDate, $range] = $this->getDateRangeAndType($startDate, $endDate, $range);
            $dateRange = $this->generateDateRange($startDate, $endDate, $range);
            $data = $this->prepareDataSet($forms, $dateRange);

            $labelArray = $this->generateLabels($dateRange);
            $label = json_encode($labelArray);
            $dataSet = json_encode($data['dataset']);
            return [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'range' => $range,
                'data' => $data,
                'label' => $label,
                'dataSet' => $dataSet,
            ];
        }, hasTransaction: false);

    }

    private function getDateRangeAndType(?string $from = null, ?string $end = null, ?string $rang = null): array
    {
        $startDate = $from ? Carbon::create($from) : Carbon::now()->startOfMonth();
        $endDate = $end ? Carbon::create($end) : Carbon::now()->endOfMonth();
        $range = $end ?? 'month';

        return [$startDate, $endDate, $range];
    }

    private function generateDateRange(Carbon $startDate, Carbon $endDate, string $range): array
    {
        $dateRange = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dateRange[] = $currentDate->format('Y-m-d');
            $currentDate->add($this->getDateInterval($range));
        }

        if (end($dateRange) != $endDate->format('Y-m-d')) {
            $dateRange[] = $endDate->format('Y-m-d');
        }

        return $dateRange;
    }

    private function getDateInterval(string $range): \DateInterval
    {
        return match ($range) {
            'year' => new \DateInterval('P1Y'),
            'week' => new \DateInterval('P1W'),
            'day' => new \DateInterval('P1D'),
            default => new \DateInterval('P1M')
        };
    }

    private function prepareDataSet($forms, $dateRange): array
    {
        $data = ['dataset' => []];

        foreach ($forms as $j => $form) {
            $data['dataset'][$j]['label'] = $form->title;
            $data['dataset'][$j]['data'] = $this->countInboxesForDateRanges($form, $dateRange);
            $data['dataset'][$j]['borderWidth'] = 1;
        }

        return $data;
    }

    private function countInboxesForDateRanges($form, $dateRange): array
    {
        $data = [];

        for ($i = 0; $i < count($dateRange) - 1; $i++) {
            $data[] = $form->inbox()->whereBetween('created_at', [$dateRange[$i], $dateRange[$i + 1]])->count();
        }

        return $data;
    }

    private function generateLabels($dateRange): array
    {
        $labels = [];

        for ($i = 0; $i < count($dateRange) - 1; $i++) {
            $labels[] = "{$dateRange[$i]} - {$dateRange[$i + 1]}";
        }

        return $labels;
    }
}
