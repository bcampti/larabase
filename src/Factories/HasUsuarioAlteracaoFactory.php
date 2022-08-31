<?php

namespace Bcampti\Larabase\Factories;

trait HasUsuarioAlteracaoFactory
{
    public function setUsuarioAlteracao($usuario)
    {
        return $this->state([
            'id_usuario_alteracao' => $usuario->id,
        ]);
    }
}
