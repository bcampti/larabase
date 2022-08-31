<?php

namespace Bcampti\Larabase\Factories;

use App\Models\Sistema\Organizacao;

trait HasOrganizacaoFactory
{
    public function setOrganizacao(Organizacao $organizacao)
    {
        return $this->state([
            'id_organizacao' => $organizacao->id,
        ]);
    }
}
