<?php

// config for Bcampti/Larabase

return [

    /*
	 |--------------------------------------------------------------------------
	 | Ativa o debug das quary's que estão sendo executadas
	 |--------------------------------------------------------------------------
	 */
    'debug_query' => env('DEBUG_QUERY', false),
    
    'prefix' => null,
    'middleware' => ['web'],
];
