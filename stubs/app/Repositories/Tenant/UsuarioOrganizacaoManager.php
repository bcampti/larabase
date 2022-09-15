<?php

namespace App\Repositories\Tenant;

use Bcampti\Larabase\Enums\CargoUsuarioEnum;
use App\Models\Tenant\Organizacao;
use App\Models\Tenant\Usuario;
use App\Models\Tenant\UsuarioOrganizacao;
use Bcampti\Larabase\Repositories\TenantManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsuarioOrganizacaoManager extends TenantManager
{
	protected $class_model = UsuarioOrganizacao::class;

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
			if( CargoUsuarioEnum::SUPORTE->equals($user->cargo) )
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