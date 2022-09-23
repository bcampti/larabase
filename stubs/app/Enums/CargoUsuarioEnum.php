<?php
namespace App\Enums;

enum CargoUsuarioEnum:string
{
    case ADMIN = 'Administrador';
    case USUARIO = 'Usuário';

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
                if( is_array($permissao) ){
                    return in_array(auth()->user()->type->value, $permissao);
                }else if( in_array($permissao, [UserTypeEnum::PROPRIETARIO->value, CargoUsuarioEnum::USUARIO->value]) ){
                    return true;
                }
                return false;
            
            default:
                if( is_array($permissao) ){
                    return in_array(auth()->user()->type->value, $permissao);
                }else{
                    if( auth()->user()->type->value==$permissao ){
                        return true;
                    }
                }
                return false;
        }
        return false;
    }
}