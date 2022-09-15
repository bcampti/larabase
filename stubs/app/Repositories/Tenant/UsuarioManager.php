<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Usuario;
use Bcampti\Larabase\Repositories\TenantManager;

class UsuarioManager extends TenantManager
{
	protected $class_model = Usuario::class;
}