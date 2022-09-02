<?php

namespace Bcampti\Larabase\Filtro;

use Bcampti\Larabase\Enums\StatusAccountEnum;
use Bcampti\Larabase\Filtro\AbstractFiltro;
use Bcampti\Larabase\Models\Account;

class AccountFiltro extends AbstractFiltro
{
	public $account;
	
    public function init()
	{
		$this->account = new Account();
		$this->account->status = StatusAccountEnum::ATIVO;
	}

	public function getOrderBy()
	{
		return 'name';
	}
	
	public function getDirecao()
	{
		return 'asc';
	}
}