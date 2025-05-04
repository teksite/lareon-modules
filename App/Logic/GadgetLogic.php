<?php

namespace Lareon\Modules\Gadget\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Lareon\Modules\Gadget\App\Models\Gadget;
use Teksite\Extralaravel\Traits\TrashMethods;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class GadgetLogic
{
    use TrashMethods;

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            return app(FetchDataService::class)(Gadget::class, ['title', 'label'], ...$fetchData);
        });
    }

    public function register(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            return Gadget::query()->create($inputs);
        });
    }

    public function change(array $inputs, Gadget $gadget)
    {

        return app(ServiceWrapper::class)(function () use ($inputs, $gadget) {
            $gadget->update($inputs);

            return $gadget;
        });
    }

    public function delete(Gadget $gadget)
    {
        return app(ServiceWrapper::class)(function () use ($gadget) {
            $gadget->delete();

        });
    }

    public function load(array $inputs)
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $label=$inputs['attributes']['id'];
            return  View::exists("widgets.$label") ? view("widgets.$label" ,compact('inputs'))->render() : Gadget::query()->firstWhere('label',$label)?->body;
        });
    }

    protected function getModelClass(): string
    {
        return Gadget::class;
    }
}

