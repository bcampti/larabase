<?php

namespace Bcampti\Larabase\Repositories\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Filtro\Tenant\UsuarioOrganizacaoFiltro;
use Bcampti\Larabase\Models\Tenant\UsuarioOrganizacao;
use Bcampti\Larabase\Repositories\PaginateInterface;
use Bcampti\Larabase\Repositories\TenantManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsuarioOrganizacaoManager extends TenantManager implements PaginateInterface
{
	protected $class_model = UsuarioOrganizacao::class;

	public function paginate(Request $request)
	{
	    $filtro = new UsuarioOrganizacaoFiltro($request);
	    
		$query = $this->getQuery()
			->select("usuario_organizacao.*")
			->join("organizacao", "organizacao.id", "usuario_organizacao.id_organizacao");

		$query->with("organizacao")
			->where("id_usuario", auth()->id());

		$query->whereHas("organizacao", function($query2) use ($filtro)
		{
			$query2->where("organizacao.status", StatusEnum::ATIVO);

			$query2->when($filtro->search, function ($query) use ($filtro) {
				$query->where(function($q) use ($filtro) {
					$q->whereRaw("lower(organizacao.nome) like '".Str::lower($filtro->search)."%'");
				});
			});
		});
		
		$filtro->setTotal($query->count());
		
		if( !empty($filtro->orderBy) ){
			$query->orderBy( $filtro->orderBy, $filtro->direcao );
		}
		$query->offset($filtro->inicio)->limit( $filtro->limit )
				->select($this->newInstance()->getTable().".*");
		
		$filtro->setItems($query->get());
		
		return $filtro;
	}

	public function getUsuarioOrganizacao($id_organizacao):?UsuarioOrganizacao
	{
		if( is_empty($id_organizacao) ){
			throw new ModelNotFoundException("O registro não existe ou não pode ser localizado");
		}

		$usuarioOrganizacao = $this->getQuery()
			->where("id_organizacao", $id_organizacao)
			->where("id_usuario", auth()->id())->first();

		if( is_empty($usuarioOrganizacao) ){
			throw new ModelNotFoundException("O registro não existe ou não pode ser localizado");
		}
		return $usuarioOrganizacao;
	}
}