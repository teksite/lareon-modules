<?php

namespace Lareon\Modules\Questionnaire\App\Logic;

use Illuminate\Support\Carbon;
use Lareon\Modules\Questionnaire\App\Models\Form;
use Teksite\Handler\Actions\ServiceWrapper;

class AnalyticInboxLogic
{
    public function generate($startDate = null, $endDate = null, $range = 'month')
    {
        $startDate = Carbon::parse($startDate ?? now()->startOfMonth())->startOfDay();
        $endDate = Carbon::parse($endDate ?? now()->endOfMonth())->endOfDay();

        return app(ServiceWrapper::class)(function () use ($startDate, $endDate, $range) {
            $dateRanges = $this->generateDateRange($startDate, $endDate, $range);
            $data = $this->fetchInboxCounts($dateRanges);
            $chartData = $this->formatForChartJs($data, $dateRanges);
            return [
                'data' => $data,
                'chart' => $chartData,
            ];
        }, hasTransaction: false);
    }

    private function generateDateRange(Carbon $startDate, Carbon $endDate, string $range): array
    {
        $interval = match ($range) {
            'day' => '1 day',
            'week' => '1 week',
            'year' => '1 year',
            default => '1 month',
        };

        $dates = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $dates[] = [
                'start' => $current->copy(),
                'end' => min($current->copy()->add($interval)->subSecond(), $endDate)
            ];
            $current->add($interval);
        }

        return $dates;
    }

    private function fetchInboxCounts(array $dateRanges): array
    {
        $results = Form::with(['inbox' => function ($query) use ($dateRanges) {
            $query->select('form_id', 'created_at')
                ->whereBetween('created_at', [
                    $dateRanges[0]['start'],
                    $dateRanges[count($dateRanges)-1]['end']
                ]);
        }])->cursor();

        $inboxesGroup = [];

        foreach ($results as $form) {
            $counts = array_fill(0, count($dateRanges), 0);

            foreach ($form->inbox as $inbox) {
                foreach ($dateRanges as $index => $range) {
                    if ($inbox->created_at->between($range['start'], $range['end'])) {
                        $counts[$index]++;
                        break;
                    }
                }
            }

            $inboxesGroup[$form->title] = array_combine(
                array_map(fn($range) => $range['start']->format('Y-m-d'), $dateRanges),
                $counts
            );
        }

        return $inboxesGroup;
    }

    private function formatForChartJs(array $data, array $dateRanges): array
    {
        // Extract labels (dates) from date ranges
        $labels = array_map(fn($range) => $range['start']->format('Y-m-d'), $dateRanges);

        // Prepare datasets (one per form)
        $datasets = [];
        foreach ($data as $formTitle => $counts) {
            $datasets[] = [
                'label' => $formTitle,
                'data' => array_values($counts), // Counts in the same order as labels
//                'borderColor' => $this->generateRandomColor(), // Optional: Random color for each form
//                'backgroundColor' => $this->generateRandomColor(0.2), // Optional: Semi-transparent for bars
                'fill' => false, // Set to true for filled charts like area charts
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    private function generateRandomColor(float $opacity = 1): string
    {
        // Generate a random RGB color
        $r = mt_rand(0, 255);
        $g = mt_rand(0, 255);
        $b = mt_rand(0, 255);
        return "rgba($r, $g, $b, $opacity)";
    }
}
