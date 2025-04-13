<?php

namespace Lareon\Modules\Questionnaire\App\Logic;

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
        $filename='receives-'.Carbon::now()->format('Y_m_d_H_i_s').'.xlsx';

        return app(ServiceWrapper::class)(function () use ($filename ,$input) {
            $query =Inbox::query()
                ->when(isset($input['form']),function($query) use ($input){
                    return $query->where('form_id',$input['form']);
                })
                ->when(isset($input['date']['start']),function($query) use ($input){
                    return $query->whereDate('created_at','>=',$input['date']['start']);
                })
                ->when(isset($input['date']['end']),function($query) use ($input){
                    return $query->whereDate('created_at','<=',$input['date']['end']);
                });
            return Excel::download(new FormInboxesExport($query), $filename);
        } ,hasTransaction:false);
    }
}

