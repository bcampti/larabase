<?php

namespace Bcampti\Larabase\Repositories;

use Bcampti\Larabase\Filtro\OrganizacaoFiltro;
use Bcampti\Larabase\Models\Tenant\Organizacao;
use Bcampti\Larabase\Repositories\PaginateInterface;
use Bcampti\Larabase\Repositories\TenantManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizacaoManager extends TenantManager implements PaginateInterface
{
	protected $class_model = Organizacao::class;

	public function paginate(Request $request)
	{
	    $filtro = new OrganizacaoFiltro($request);
	    
		$query = $this->getQuery($filtro->account);
		
		$query->when($filtro->search, function ($query) use ($filtro) {
			$query->where(function($q) use ($filtro) {
				$q->whereRaw("lower(nome) like '".Str::lower($filtro->search)."%'");
					//->orWhere("status", "like", Str::lower($filtro->search)."%");
			});
		});
		
		$filtro->setTotal($query->count());
		
		if( !empty($filtro->orderBy) ){
			$query->orderBy( $filtro->orderBy, $filtro->direcao );
		}
		if( $filtro->orderBy != "id" ){
		    $query->orderBy("id");
		}
		$query->offset($filtro->inicio)->limit( $filtro->limit )
				->select($this->newInstance()->getTable().".*");
		
		$filtro->setItems($query->get());
		
		return $filtro;
	}

}