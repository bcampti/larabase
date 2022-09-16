<?php
namespace Bcampti\Larabase\Enums;

enum CargoUsuarioEnum:string
{
    case SUPORTE = 'Suporte';
    case PROPRIETARIO = 'Proprietário';
    case ADMIN = 'Administrador';

    public function color(): string
    {
        return match($this) 
        {
            CargoUsuarioEnum::SUPORTE => 'info',
            CargoUsuarioEnum::PROPRIETARIO => 'dark',
            CargoUsuarioEnum::ADMIN => 'warnning',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
    
}