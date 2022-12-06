<?php

// config for Bcampti/Larabase

return [

    /*
	 |--------------------------------------------------------------------------
	 | Ativa o debug das quaries que estão sendo executadas
	 |--------------------------------------------------------------------------
	 */
    'debug_query' => env('DEBUG_QUERY', false),
    
    /* 
    |--------------------------------------------------------------------------
    | Opcao utilizada na criação de models e migrations, adiciona profixo nas tabelas de banco de dados.
    | Ex.: 'tb_', default ''
    |--------------------------------------------------------------------------
    */
    'table_prefix' => '',

    /*
	 |--------------------------------------------------------------------------
	 | Opção de controle de acesso aos recursos/rotas do sistema
	 |--------------------------------------------------------------------------
     | Supported: "cargo", "permissao"
     | * "cargo" => o controle e realizado por cargo de usuario, dos os recursos/rotas ficam liberados com exceção dos recuros/rotas mapeadas
     | * "permissao" => o controle e realizado por grupos de permissão
     | 
	 */
    'controle' => 'cargo',
    
    /* Configuracao de Routes */
    'prefix' => null,
    'middleware' => ['web'],
];
