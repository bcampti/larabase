<?php

namespace App\Http\Requests\Tenant;

use App\Models\Tenant\UserInvitation;
use Bcampti\Larabase\Enums\CargoUsuarioEnum;
use Bcampti\Larabase\Rules\UniqueToOrg;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserInvitationRequest extends FormRequest
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
            "email" => [
                "required", 
                "string", 
                "email", 
                "max:255", 
                new UniqueToOrg(UserInvitation::class, "Já existe um convite para este e-mail.")
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
            "email" => "e-mail",
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
