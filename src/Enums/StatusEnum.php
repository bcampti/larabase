<?php
namespace Bcampti\Larabase\Enums;

enum StatusEnum:string
{
    case ATIVO = 'ATIVO';
    case INATIVO = 'INATIVO';

    public function label(): string
    {
        return match($this) 
        {
            StatusEnum::ATIVO => 'Ativo',
            StatusEnum::INATIVO => 'Inativo',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            StatusEnum::ATIVO => 'success',
            StatusEnum::INATIVO => 'dark',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
}