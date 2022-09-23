<?php
namespace Bcampti\Larabase\Enums;

enum UserTypeEnum:string
{
    case SUPORTE = 'Suporte';
    case PROPRIETARIO = 'Proprietário';
    case USUARIO = 'Usuário';

    public function color(): string
    {
        return match($this) 
        {
            UserTypeEnum::SUPORTE => 'dark',
            UserTypeEnum::PROPRIETARIO => 'info',
            UserTypeEnum::USUARIO => 'warning',
        };
    }

    public function equals( $name ): bool
    {
        return is_empty($name) ? false : $this->name == $name;
    }
}