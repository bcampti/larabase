<?php

namespace Bcampti\Larabase\Models\Core;

use App\Models\Sistema\Usuario;

trait HasUsuarioCriacao
{
    public static function bootHasUsuarioCriacao()
    {
        static::creating(function($model)
        {
            if( auth()->check() ){
                $model->id_usuario_criacao = auth()->user()->id;
            }
        });
    }

    public function usuarioCriacao()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_criacao');
    }
}