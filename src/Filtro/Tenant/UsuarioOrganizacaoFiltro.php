<?php

namespace Bcampti\Larabase\Filtro\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Filtro\AbstractFiltro;

class UsuarioOrganizacaoFiltro extends AbstractFiltro
{
    public function init()
	{
		$this->status = StatusEnum::ATIVO;
	}

	public function getOrderBy()
	{
		return 'organizacao.nome';
	}
	
	public function getDirecao()
	{
		return 'asc';
	}
}