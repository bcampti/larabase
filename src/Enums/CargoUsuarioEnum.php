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
    
}