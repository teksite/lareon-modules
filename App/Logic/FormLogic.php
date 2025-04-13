<?php

namespace Lareon\Modules\Questionnaire\App\Logic;

use Illuminate\Support\Arr;
use Lareon\CMS\App\Enums\ActionTypesEnum;
use Lareon\CMS\App\Events\CreateOrUpdateInstanceEvent;
use Lareon\Modules\Page\App\Models\Page;
use Lareon\Modules\Questionnaire\App\Models\Form;
use Teksite\Extralaravel\Traits\TrashMethods;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class FormLogic
{
    use TrashMethods;

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Form::class, ['title'], ...$fetchData);
        });
    }

    public function register(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $form = Form::query()->create(Arr::except($inputs, ['rules', 'announcements']));
            $form->validationRules()->create(['rules' => $inputs['rules'] ?? []]);
            $form->announcement()->create($inputs['announcements'] ?? []);

            return $form;
        });
    }

    public function change(array $inputs, Form $form)
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $form) {
            $form->update(Arr::except($inputs, ['rules', 'announcements']));
            $form->validationRules()->updateOrCreate(['form_id' => $form->id], ['rules' => $inputs['rules'] ?? []]);
            $form->announcement()->updateOrCreate(['form_id' => $form->id], $inputs['announcements'] ?? []);
            return $form;
        });
    }

    public function delete(Form $form)
    {
        return app(ServiceWrapper::class)(function () use ($form) {

            $form->delete();
        });
    }

    protected function getModelClass(): string
    {
        return Form::class;
    }


}


