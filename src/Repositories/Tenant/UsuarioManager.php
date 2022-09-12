<?php

namespace Bcampti\Larabase\Repositories\Tenant;

use Bcampti\Larabase\Models\Tenant\Usuario;
use Bcampti\Larabase\Repositories\TenantManager;

class UsuarioManager extends TenantManager
{
	protected $class_model = Usuario::class;
}