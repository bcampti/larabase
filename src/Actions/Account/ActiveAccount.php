<?php

namespace Bcampti\Larabase\Actions\Account;

use App\Models\User;
use Bcampti\Larabase\Enums\StatusAccountEnum;
use Bcampti\Larabase\Exceptions\GenericMessage;

class ActiveAccount
{
    /**
     * Ativa o periodo de teste da companhia
     *
     * @param  User $user
     */
    public function execute(User $user)
    {
        $account = $user->account;
        if( is_empty($account) ){
            throw new GenericMessage('Não foi possível identificar a sua conta.');
        }
        $account->status = StatusAccountEnum::ATIVO;
        $account->save();
    }

}
