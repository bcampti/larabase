<?php

namespace App\Http\Requests\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class OrganizacaoRequest extends FormRequest
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
            "nome" => [
                "required",
                "string"
            ],
            "status" => [
                "required", 
                "string",
                new Enum(StatusEnum::class)
            ]

            /* "razao_social" => [
                "required",
                "string"
            ],
            "cnpj" => [
                "required",
                "string"
            ],
            "endereco" => [
                "nullable",
                "string"
            ],
            "bairro" => [
                "nullable",
                "string"
            ],
            "cep" => [
                "nullable",
                "string"
            ],
            "cidade" => [
                "nullable",
                "string"
            ],
            "estado" => [
                "nullable",
                "string"
            ],
            "email" => [
                "nullable",
                "string"
            ],
            "telefone" => [
                "nullable",
                "string"
            ],

            "id_account"=>[
                "required",
                "integer",
                Rule::exists(Account::class,"id"),
            ] */
        ];
    }

    /**
     * Mensagem personalizada que sera apresentada
     **/
    public function messages()
    {
        return [
            //"nome.required" => "O Nome deve ser informado.",
            //"status.required" => "A situação deve ser informada.",
            //"status.in" => "A situação informada não é valida.",
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
            "nome" => "Nome",
            "status" => "situação",
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
            'slug' => Str::slug($this->slug),
        ]); */
    }
}
