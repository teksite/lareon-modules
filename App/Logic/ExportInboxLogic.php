<?php

namespace Lareon\Modules\Questionnaire\App\Logic;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Lareon\Modules\Questionnaire\App\Exports\FormInboxesExport;
use Lareon\Modules\Questionnaire\App\Models\Inbox;
use Maatwebsite\Excel\Facades\Excel;
use Teksite\Handler\Actions\ServiceWrapper;

class ExportInboxLogic
{
    public function export(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            $filename = sprintf('receives-%s.xlsx', Carbon::now()->format('Y_m_d_H_i_s'));
            $query = $this->buildQuery($input);

            return Excel::download(new FormInboxesExport($query), $filename);
        }, hasTransaction: false);
    }

    private function buildQuery(array $input): Builder
    {
        return Inbox::query()
            ->when($input['form'] ?? null, fn($query, $form) => $query->where('form_id', $form))
            ->when($input['date']['start'] ?? null, fn($query, $start) => $query->whereDate('created_at', '>=', $start))
            ->when($input['date']['end'] ?? null, fn($query, $end) => $query->whereDate('created_at', '<=', $end));
    }
}

