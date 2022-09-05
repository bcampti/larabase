<?php

namespace Bcampti\Larabase\Actions\Account;

use App\Models\User;
use Bcampti\Larabase\Repositories\AccountManager;

class CreateAccount
{
    public static function execute( User $user )
    {
        $accountManager = new AccountManager();
        
        $account = $accountManager->createDatabase($user->account);

        $accountManager->adicionarDadosPadraoNovaConta($user, $account);
    }
}
