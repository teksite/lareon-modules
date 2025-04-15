<?php

namespace Lareon\Modules\Questionnaire\App\Logic;

use Illuminate\Support\Arr;
use Lareon\Modules\Questionnaire\App\Events\NewFormRegisteredEvent;
use Lareon\Modules\Questionnaire\App\Models\Form;
use Lareon\Modules\Questionnaire\App\Models\Inbox;
use Teksite\Extralaravel\Traits\TrashMethods;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class InboxLogic
{
    use TrashMethods;

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Inbox::class, ...$fetchData);
        });
    }

    public function getByForm(Form|int $form, mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData, $form) {
            $frm = $form instanceof Form ? $form : Form::find($form);

            return app(FetchDataService::class)($frm->inbox(), ['created_at'], ...$fetchData);
        });
    }

    public function register(Form $form, array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($form, $inputs) {
            $inbox = $form->inbox()->create([
                'data' => Arr::except($inputs, ['data_info']),
                'ip_address' => request()->ip(),
                'url' => $inputs['data_info']['url']
            ]);

            event(new NewFormRegisteredEvent($form, $inbox));
            return $inbox;
        });
    }

    public function change(array $inputs, Inbox $inbox)
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $inbox) {
            $preNote = $inbox->note;
            $newNote = [
                'author' => auth()->user()->name . ' ' . auth()->id(),
                'note' => $inputs['note'],
            ];
            $note = collect($preNote)->push($newNote);
            $inbox->note = $note;
            $inbox->save();
            return $inbox;
        });
    }

    public function delete(Inbox $inbox)
    {
        return app(ServiceWrapper::class)(function () use ($inbox) {

            $inbox->delete();
        });
    }

    public function markAsRead(Inbox $inbox)
    {
        if (is_null($inbox->read_at) && is_null($inbox->user_id)) {
            $inbox->read_at = now();
            $inbox->user_id = auth()->id();
            $inbox->save();
        }
    }

    protected function getModelClass(): string
    {
        return Inbox::class;
    }


}


