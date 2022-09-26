<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Usuario;
use App\Models\User;
use Bcampti\Larabase\Repositories\TenantManager;

class UsuarioManager extends TenantManager
{
	protected $class_model = Usuario::class;

	public function checkOrCreateUserSuporte(User $user)
	{
		$usuario = Usuario::find($user->id);
		if( is_null($usuario) ){
			$usuario = new Usuario();
			$usuario->id = $user->id;
			$usuario->name = $user->name;
			$usuario->email = $user->email;
			$usuario->password = $user->password;
			$usuario->save();
		}
		return true;
	}
}
