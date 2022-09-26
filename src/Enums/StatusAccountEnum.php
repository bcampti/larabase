<?php
namespace Bcampti\Larabase\Enums;

enum StatusAccountEnum:string
{
	case NOVA = "NOVA";
	case TESTE = "TESTE";
    case ATIVO = 'ATIVO';
    case INATIVO = 'INATIVO';

    public function lable(): string
    {
        return match($this) 
        {
            StatusAccountEnum::NOVA => 'Nova',
            StatusAccountEnum::TESTE => 'Teste',
            StatusAccountEnum::ATIVO => 'Ativo',
            StatusAccountEnum::INATIVO => 'Inativo',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            StatusAccountEnum::NOVA => 'info',
            StatusAccountEnum::TESTE => 'warnning',
            StatusAccountEnum::ATIVO => 'success',
            StatusAccountEnum::INATIVO => 'dark',
        };
    }

    public function equals( $value ): bool
    {
        return is_empty($value) ? false : $this->value == $value;
    }
}