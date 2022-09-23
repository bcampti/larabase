<?php

namespace App\Repositories\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use App\Filtro\Tenant\OrganizacaoFiltro;
use App\Models\Tenant\Organizacao;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Bcampti\Larabase\Repositories\PaginateInterface;
use Bcampti\Larabase\Repositories\TenantManager;
use Illuminate\Http\Request;

class OrganizacaoManager extends TenantManager implements PaginateInterface
{
	protected $class_model = Organizacao::class;

	public function paginate(Request $request)
	{
	    $filtro = new OrganizacaoFiltro($request);
	    
		$query = $this->getQuery($filtro->organizacao);
		
		$query->when($filtro->search, function ($query) use ($filtro) {
			$query->where(function($q) use ($filtro) {
				$q->whereRaw("lower(nome) like '".strLower($filtro->search)."%'");
					//->orWhere("status", "like", strLower($filtro->search)."%");
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

	public function getOrganizacoesComAcesso(Request $request)
	{
	    $filtro = new OrganizacaoFiltro($request);
	    
		$query = $this->getQuery()
			->select("organizacao.*");

		if( !UserTypeEnum::SUPORTE->equals(auth()->user()->type->value) ){
			$query->join("usuario_organizacao", function ($join) {
				$join->on( "organizacao.id", "=","usuario_organizacao.id_organizacao")->where("usuario_organizacao.id_usuario", auth()->id());
			});
		}
			
		$query->when($filtro->search, function ($query2) use ($filtro) {
			$query2->where(function($q) use ($filtro) {
				$q->whereRaw("lower(organizacao.nome) like '".strLower($filtro->search)."%'");
			});
		})->where("organizacao.status", StatusEnum::ATIVO);

		$filtro->setTotal($query->count());
		
		if( !empty($filtro->orderBy) ){
			$query->orderBy( $filtro->orderBy, $filtro->direcao );
		}
		$query->offset($filtro->inicio)->limit( $filtro->limit )
				->select($this->newInstance()->getTable().".*");
		
		$filtro->setItems($query->get());
		
		return $filtro;
	}

}