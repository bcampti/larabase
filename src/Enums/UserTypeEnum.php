<?php
namespace Bcampti\Larabase\Enums;

enum UserTypeEnum:string
{
    case SUPORTE = 'Suporte';
    case PROPRIETARIO = 'Proprietário';

    public function color(): string
    {
        return match($this) 
        {
            UserTypeEnum::SUPORTE => 'dark',
            UserTypeEnum::PROPRIETARIO => 'info',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
}