<?php
namespace App\Enums;

use App\Models\Tenant\UsuarioOrganizacao;
use Bcampti\Larabase\Enums\UserTypeEnum;

enum CargoUsuarioEnum:string
{
    case ADMIN = 'ADMIN';
    case USUARIO = 'USUARIO';

    public function label(): string
    {
        return match($this) 
        {
            CargoUsuarioEnum::ADMIN => 'Administrador',
            CargoUsuarioEnum::USUARIO => 'Usuário',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            CargoUsuarioEnum::ADMIN => 'info',
            CargoUsuarioEnum::USUARIO => 'success',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
    
    public static function validaPermissao( $permissao )
    {
        switch (auth()->user()->type->value)
        {
            case UserTypeEnum::SUPORTE->value:
                return true;

            case UserTypeEnum::PROPRIETARIO->value:
                return true;
    
            default:
                if( is_array($permissao) ){
                    return in_array(UsuarioOrganizacao::current()->cargo->value, $permissao);
                }else{
                    if( UsuarioOrganizacao::current()->cargo->equals($permissao) ){
                        return true;
                    }
                }
                return false;
        }
        return false;
    }
}