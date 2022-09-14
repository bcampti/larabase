<?php
namespace Bcampti\Larabase\Enums;

enum CargoUsuarioEnum:string
{
    case SUPORTE = 'Suporte';
    case ADMIN = 'Administrador';
	case USUARIO = "Usuário";

    public function color(): string
    {
        return match($this) 
        {
            CargoUsuarioEnum::SUPORTE => 'info',
            CargoUsuarioEnum::ADMIN => 'dark',
            CargoUsuarioEnum::USUARIO => 'warnning',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
    
}