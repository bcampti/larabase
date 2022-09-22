<?php

namespace Bcampti\Larabase\Scopes;

use App\Models\Tenant\Organizacao;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrganizacaoScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * 
     * para realizar uma consulta sem este scope, utilize o metodo withoutGlobalScopes()
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if( $model->enableOrganizacaoScope )
        {
            if( !Organizacao::checkCurrent() )
            {
                info(__CLASS__." - Model: ".$model::class);
                throw new GenericMessage("Organização não identificada, recarregue e tente novamente");
            }
            $builder->where($model->getTable().'.id_organizacao', Organizacao::currentId());
        }
    }
}