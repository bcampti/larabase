<?php

namespace Bcampti\Larabase\Repositories\Core;

use Illuminate\Http\Request;

interface PaginateInterface {

    function paginate(Request $request);
    
}