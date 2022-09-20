<?php

namespace Bcampti\Larabase\Factories;

use App\Models\Tenant\Organizacao;

trait HasOrganizacaoFactory
{
    public function setOrganizacao(Organizacao $organizacao)
    {
        return $this->state([
            'id_organizacao' => $organizacao->id,
        ]);
    }
}
