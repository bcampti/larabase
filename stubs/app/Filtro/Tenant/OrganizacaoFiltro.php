<?php

namespace App\Filtro\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Filtro\AbstractFiltro;
use App\Models\Tenant\Organizacao;

class OrganizacaoFiltro extends AbstractFiltro
{
	public $organizacao;
	
    public function init()
	{
		$this->organizacao = new Organizacao();
		$this->organizacao->status = StatusEnum::ATIVO;
	}

	public function getOrderBy()
	{
		return 'nome';
	}
	
	public function getDirecao()
	{
		return 'asc';
	}
}