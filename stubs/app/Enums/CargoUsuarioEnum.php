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
        switch (auth()->user()->type->name)
        {
            case UserTypeEnum::SUPORTE->name:
                return true;

            case UserTypeEnum::PROPRIETARIO->name:
                if( is_array($permissao) ){
                    return in_array(auth()->user()->type->name, $permissao);
                }else if( in_array($permissao, [UserTypeEnum::PROPRIETARIO->name, CargoUsuarioEnum::USUARIO->name]) ){
                    return true;
                }
                return false;
            
            default:
                if( is_array($permissao) ){
                    return in_array(auth()->user()->type->name, $permissao);
                }else{
                    if( auth()->user()->type->name==$permissao ){
                        return true;
                    }
                }
                return false;
        }
        return false;
    }
}