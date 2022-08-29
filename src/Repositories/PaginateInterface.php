<?php

namespace Bcampti\Larabase\Repositories;

use Illuminate\Http\Request;

interface PaginateInterface {

    function paginate(Request $request);
    
}