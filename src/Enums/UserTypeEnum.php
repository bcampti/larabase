<?php
namespace Bcampti\Larabase\Enums;

enum UserTypeEnum:string
{
    case SUPORTE = 'SUPORTE';
    case PROPRIETARIO = 'PROPRIETARIO';
    case USUARIO = 'USUARIO';

    public function label(): string
    {
        return match($this) 
        {
            UserTypeEnum::SUPORTE => 'Suporte',
            UserTypeEnum::PROPRIETARIO => 'Proprietário',
            UserTypeEnum::USUARIO => 'Usuário',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            UserTypeEnum::SUPORTE => 'dark',
            UserTypeEnum::PROPRIETARIO => 'info',
            UserTypeEnum::USUARIO => 'warning',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
}