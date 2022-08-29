<?php

namespace Bcampti\Larabase\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * UniqueToOrg
 * Valida o campo como unique incluido a id_organizacao atravez do GlobalScope do model
 */
class UniqueToOrg implements Rule
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
        $field = explode(".", $attribute);
        if( count($field)>1 ){
            $field = $field[1];
        }else{
            $field = $field[0];
        }
        $query = $this->model->whereRaw("lower(".$field.") = '".strLower($value)."'");
        if( request()->method()==="PUT" && !is_empty(request()->route("id")) ){
            $query->where("id","<>",request()->route("id"));
        }
        return $query->count()===0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if( is_null($this->customMessage) ){
            return __('Já existe um registro com essa informação.');
        }else{
            return $this->customMessage;
        }
    }
}
