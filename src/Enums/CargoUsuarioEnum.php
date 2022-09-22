<?php
namespace Bcampti\Larabase\Enums;

enum CargoUsuarioEnum:string
{
    case SUPORTE = 'Suporte';
    case PROPRIETARIO = 'Proprietário';
    case USUARIO = 'Usuário';

    public function color(): string
    {
        return match($this) 
        {
            CargoUsuarioEnum::SUPORTE => 'dark',
            CargoUsuarioEnum::PROPRIETARIO => 'info',
            CargoUsuarioEnum::USUARIO => 'success',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
    
    public static function validaPermissao( $permissao )
    {
        switch (auth()->user()->cargo->name)
        {
            case CargoUsuarioEnum::SUPORTE->name:
                return true;

            case CargoUsuarioEnum::PROPRIETARIO->name:
                if( is_array($permissao) ){
                    return in_array(auth()->user()->cargo->name, $permissao);
                }else if( in_array($permissao, [CargoUsuarioEnum::PROPRIETARIO->name, CargoUsuarioEnum::USUARIO->name]) ){
                    return true;
                }
                return false;
            
            default:
                if( is_array($permissao) ){
                    return in_array(auth()->user()->cargo->name, $permissao);
                }else{
                    if( auth()->user()->cargo->name==$permissao ){
                        return true;
                    }
                }
                return false;
        }
        return false;
    }
}