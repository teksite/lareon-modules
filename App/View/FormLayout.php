<?php

namespace Lareon\Modules\Questionnaire\App\View;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Lareon\Modules\Questionnaire\App\Models\Form;

class FormLayout extends Component
{
    public Form $form;
    public bool $ajax;
    /**
     * Create a new component instance.
     */
    public function __construct(int|string $form ,$ajax =true)
    {
        $this->form = Form::find($form);
        $this->ajax =$ajax;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('questionnaire::client.layouts.form-layout');
    }
}
