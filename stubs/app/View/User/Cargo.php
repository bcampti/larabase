<?php

namespace App\View\Cargo;

use Illuminate\View\Component;

class Cargo extends Component
{
    public $cargo;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($cargo)
    {
        $this->cargo = $cargo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        dd($this->cargo);
        return view('components.user.cargo');
    }
}
