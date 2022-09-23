<?php

namespace App\View\Model;

use Bcampti\Larabase\Enums\StatusEnum;
use Illuminate\View\Component;

class Status extends Component
{
    public StatusEnum $status;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.model.status');
    }
}
