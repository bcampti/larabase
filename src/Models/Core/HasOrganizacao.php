<?php

namespace Bcampti\Larabase\Models\Core;

use App\Models\Sistema\Organizacao;
use App\Scopes\OrganizacaoScope;
use Illuminate\Validation\ValidationException;

trait HasOrganizacao
{
    public $enableOrganizacaoScope = true;

    public static function bootHasOrganizacao()
    {
        static::addGlobalScope(new OrganizacaoScope);
        
        static::creating(function($model)
        {
            if( is_empty($model->id_organizacao) && !session()->has("id_organizacao") )
            {
                info(__CLASS__." - Model: ".$model::class);
                throw ValidationException::withMessages(["Organização não identificada, recarregue e tente novamente."]);
            }

			if( is_empty($model->id_organizacao) )
            {
				$model->id_organizacao = session('id_organizacao');
			}
        });
    }

    public function organizacao()
    {
        return $this->belongsTo(Organizacao::class, 'id_organizacao');
    }

}