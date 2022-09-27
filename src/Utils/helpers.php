<?php

use App\Enums\CargoUsuarioEnum;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('is_empty')) {
    /**
     * is_empty
     * Retorno true se a variavel estiver nula, vazia ou se um array estiver vazio
     * 
     * @param  mixed $var
     * @return boolean
     */
    function is_empty($var)
    {
        if (is_null($var)) {
            return true;
        }
        if ($var instanceof Collection || is_array($var)) {
            if (count($var) < 1) {
                return true;
            } else {
                return false;
            }
        }
        if ($var instanceof string && empty(trim($var))) {
            return true;
        }
        if ($var == false) {
            return true;
        }
        if ($var == "") {
            return true;
        }
        return false;
    }
}

if( !function_exists('tratarCaracteresEspeciais')) {
    /** Retorna uma string com barras invertidas adicionadas antes dos caracteres que precisam ser tratados.
    * Esses personagens são:
    * - aspa simples ( ' ) => ( \'' ) E para executar no banco adiciona mais uma aspa simples 
    * - aspas duplas ( " )
    * - barra invertida ( \ )
    * - NUL (o byte NUL)
    */
	function tratarCaracteresEspeciais( $value ){
		
		$value = addslashes($value);
		if( str_contains($value, "\'") ){
			$value = str_replace("\'", "\''", $value);
		}
		return $value;
	}
}

if( !function_exists('normalizeString')) {
    /** 
     * Normaliza o texto que será consultado na base de dados e retorna lowerCase.
     * Retorna uma string com barras invertidas adicionadas antes dos caracteres que precisam ser tratados.
     * Esses personagens são:
     * - aspa simples ( ' ) => ( \'' ) E para executar no banco adiciona mais uma aspa simples 
     * - aspas duplas ( " )
     * - barra invertida ( \ )
     * - NUL (o byte NUL)
    */
	function normalizeString( $value ){
		return strLower(tratarCaracteresEspeciais($value));
	}
}

if( !function_exists('strLower')) {
    /**
     * Torna a string lowercase com a function mb_strtolower
     *
     * @param  mixed $value
     * @return string
     */
    function strLower($value): string{
        return mb_strtolower($value, 'UTF-8');
    }
}

if( !function_exists('strUpper')) {
    /**
     * Torna a string uppercase com a function mb_strtoupper
     * 
     * Exemplo:
     *  strtoupper('Umlaute äöü in uppercase'); // outputs "UMLAUTE äöü IN UPPERCASE"
     *  mb_strtoupper('Umlaute äöü in uppercase', 'UTF-8'); // outputs "UMLAUTE ÄÖÜ IN UPPERCASE"
     *
     * @param  mixed $value
     * @return string
     */
    function strUpper($value): string{
        return mb_strtoupper($value, 'UTF-8');
    }
}

if( !function_exists('hasSuporte')) {
    /* 
     * Verifica se o usuário logado é SUPORTE
     */
    function hasSuporte()
    {
        return UserTypeEnum::SUPORTE->equals(auth()->user()->type->value);
	}
}

if( !function_exists('hasProprietario')) {
    /* 
     * Verifica se o usuário logado é PROPRIETARIO ou SUPORTE
     */
    function hasProprietario()
    {
        return UserTypeEnum::PROPRIETARIO->equals(auth()->user()->type->value) || UserTypeEnum::SUPORTE->equals(auth()->user()->type->value);
	}
}

if( !function_exists('hasPermission')) {
    /* 
     * Valida se o usuário logado possui permissao para acessar um recurso especifico.
     * considera a configuração 'larabase.controle' ('cargo','permissao')
     */
    function hasPermission( $permissao )
    {
        if( config('larabase.controle') == 'cargo' ){
            return CargoUsuarioEnum::validaPermissao($permissao);
        }else{
            return false;
        }
	}
}
