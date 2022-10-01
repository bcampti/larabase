<?php

namespace App\View\User;

use Bcampti\Larabase\Enums\UserTypeEnum;
use Illuminate\View\Component;

class Type extends Component
{
    public UserTypeEnum $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user.type');
    }
}
