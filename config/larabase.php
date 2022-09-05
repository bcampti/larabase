<?php

// config for Bcampti/Larabase

return [

    /*
	 |--------------------------------------------------------------------------
	 | Ativa o debug das quary's que estão sendo executadas
	 |--------------------------------------------------------------------------
	 */
    'debug_query' => env('DEBUG_QUERY', false),
    
    /*
     * Esta class é o model usado para configuração e identificação de cadas empresa dentro de uma mesma conta/tenant.
     *
     * Ela pode ser ou extender `Bcampti\Larabase\Models\Tenant\Organizacao::class`
     */
    "organizacao_model" => Bcampti\Larabase\Models\Tenant\Organizacao::class,
];
