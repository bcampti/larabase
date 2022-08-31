<?php

namespace Bcampti\Larabase\Factories;

trait HasUsuarioCriacaoFactory
{
    public function setUsuarioCriacao($usuario)
    {
        return $this->state([
            'id_usuario_criacao' => $usuario->id,
        ]);
    }
}
