<?php

namespace Bcampti\Larabase\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * ExistsToOrg
 * Valida se o registro existe no banco incluindo o id_organizacao atravez do GlobalScope do model
 */
class ExistsToOrg implements Rule
{
    protected $model;
    protected $customMessage;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($class, $customMessage = null)
    {
        $this->model = new $class();
        $this->customMessage = $customMessage;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->model->whereKey($value)->count()>0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if( is_null($this->customMessage) ){
            return __('O :attribute selecionado é inválido.');
        }else{
            return $this->customMessage;
        }
    }
}
