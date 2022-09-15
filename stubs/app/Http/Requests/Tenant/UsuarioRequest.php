<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
