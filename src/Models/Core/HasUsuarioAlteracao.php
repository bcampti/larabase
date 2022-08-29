<?php

namespace Bcampti\Larabase\Models\Core;

use App\Models\Sistema\Usuario;

trait HasUsuarioAlteracao
{
    public static function bootHasUsuarioAlteracao()
    {
        static::updating(function($model)
        {
            if( auth()->check() ){
                $model->id_usuario_alteracao = auth()->user()->id;
            }
        });
    }

    public function usuarioAlteracao()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_alteracao');
    }
}