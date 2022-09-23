<?php

namespace App\Repositories\Tenant;

use App\Filtro\Tenant\UsuarioOrganizacaoFiltro;
use App\Models\Tenant\Organizacao;
use App\Models\Tenant\Usuario;
use App\Models\Tenant\UsuarioOrganizacao;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Bcampti\Larabase\Repositories\PaginateInterface;
use Bcampti\Larabase\Repositories\TenantManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UsuarioOrganizacaoManager extends TenantManager implements PaginateInterface
{
	protected $class_model = UsuarioOrganizacao::class;

	public function paginate(Request $request)
	{
	    $filtro = new UsuarioOrganizacaoFiltro($request);
	    
		$query = $this->getQuery()
			->join('usuario', 'usuario.id','usuario_organizacao.id_usuario')
			->with('usuario');
		
		$query->where("id_organizacao", Organizacao::currentId());

		$query->when($filtro->search, function ($query) use ($filtro) {
			$query->whereHas('usuario', function($q) use ($filtro) {
				$q->whereRaw("lower(usuario.name) like '".strLower($filtro->search)."%'")
					->orWhereRaw("lower(email) like '". strLower($filtro->search)."%'");
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
	
	public function getUsuarioOrganizacao($id_organizacao):?UsuarioOrganizacao
	{
		if( is_empty($id_organizacao) ){
			info(__CLASS__."->".__FUNCTION__."=".__LINE__." >> id_organizacao null");
			throw new ModelNotFoundException("O registro não existe ou não pode ser localizado");
		}

		$usuarioOrganizacao = $this->getQuery()
			->where("id_organizacao", $id_organizacao)
			->where("id_usuario", auth()->id())->first();

		if( is_empty($usuarioOrganizacao) )
		{
			$user = auth()->user();
			if( UserTypeEnum::SUPORTE->equals($user->type->name) )
			{
				$organizacao = Organizacao::whereKey($id_organizacao)->first();
				if( is_empty($organizacao) )
				{
					info(__CLASS__."->".__FUNCTION__."=".__LINE__." >> organizacao nao registrada");
					throw new ModelNotFoundException("O registro não existe ou não pode ser localizado");
				}
				
				$usuario = Usuario::whereKey($user->id)->first();
				if( is_empty($usuario) )
				{
					$usuario = new Usuario();
					$usuario->id = $user->id;
					$usuario->name = $user->name;
					$usuario->email = $user->email;
					$usuario->password = $user->password;

					$usuarioManager = new UsuarioManager();
					$usuarioManager->salvar($usuario);
				}
			}
			else{
				throw new ModelNotFoundException("O registro não existe ou não pode ser localizado");
			}
		}
		return $usuarioOrganizacao;
	}
}