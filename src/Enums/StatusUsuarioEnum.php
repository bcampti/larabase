<?php
namespace Bcampti\Larabase\Enums;

enum StatusUsuarioEnum:string
{
    case ATIVO = 'Ativo';
    case INATIVO = 'Inativo';

    public function color(): string
    {
        return match($this) 
        {
            StatusUsuarioEnum::ATIVO => 'success',
            StatusUsuarioEnum::INATIVO => 'dark',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
}