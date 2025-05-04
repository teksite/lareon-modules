<?php

namespace Lareon\Modules\Gadget\App\View;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class load extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('gadget::layouts.client.load');
    }
}
