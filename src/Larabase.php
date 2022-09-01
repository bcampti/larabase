<?php

namespace Bcampti\Larabase;

use Bcampti\Larabase\Models\Organizacao;

class Larabase
{
    public static function getOrganizacaoModel(): Organizacao
    {
        $modelClass = config('larabase.organizacao_model');

        return new $modelClass();
    }
}
