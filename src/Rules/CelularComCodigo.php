<?php
namespace Bcampti\Larabase\Rules;

use Illuminate\Contracts\Validation\Rule;

class CelularComCodigo implements Rule
{
    public function passes($attribute, $value)
    {
        if( strlen($value) == 14 ) {
            $numero = preg_match('/^[+]\d{1,2}\s?\d{2}\s?\d{4,5}\d{4}$/', $value);
            if( $numero > 0 ){
                return true;
            }
            return false;
        }else{
            return preg_match('/^[+]\d{1,2}\s?\(\d{2}\)\s?\d{4,5}\-\d{4}$/', $value) > 0;
        }
    }

    public function message()
    {
    	return 'O :attribute não é um número válido.';
    }
}