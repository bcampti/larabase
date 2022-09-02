<?php
namespace Bcampti\Larabase\Enums;

enum StatusAccountEnum:string
{
	case NOVA = "Nova";
	case TESTE = "Teste";
    case ATIVO = 'Ativo';
    case INATIVO = 'Inativo';

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