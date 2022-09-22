<?php

namespace App\Filtro\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Filtro\AbstractFiltro;

class UsuarioOrganizacaoFiltro extends AbstractFiltro
{
    public function init()
	{
	}

	public function getOrderBy()
	{
		return 'usuario.name';
	}
	
	public function getDirecao()
	{
		return 'asc';
	}
}