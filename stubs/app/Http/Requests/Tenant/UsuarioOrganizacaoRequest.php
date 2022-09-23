<?php

namespace App\Http\Requests\Tenant;

use App\Enums\CargoUsuarioEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UsuarioOrganizacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * validações brasileiras comuns http://laravellegends.github.io/pt-br-validator/
     * @return array
     */
    public function rules()
    {
        return [
            "name" => [
                "required",
                "string",
            ],
            "cargo" => [
                "required",
                "string",
                new Enum(CargoUsuarioEnum::class)
            ]
        ];
    }

    /**
     * Mensagem personalizada que sera apresentada
     **/
    public function messages()
    {
        return [
            
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            "name" => "nome",
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        /* $this->merge([
            "slug" => Str::slug($this->slug),
        ]); */
    }
}
