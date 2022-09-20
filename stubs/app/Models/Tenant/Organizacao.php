<?php

namespace App\Models\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Models\Model;
use Bcampti\Larabase\Traits\HasUsuarioAlteracao;
use Bcampti\Larabase\Traits\HasUsuarioCriacao;
use Bcampti\Larabase\Traits\KeepOnSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Organizacao extends Model
{
	use UsesTenantConnection;
	use HasUsuarioCriacao;
	use HasUsuarioAlteracao;
	use HasFactory;

    use KeepOnSession;

    protected $table = "organizacao";

    protected $fillable = [
		"nome",
		"status",
		/* "razao_social",
		"cnpj",
		"endereco",
		"bairro",
		"cep",
		"cidade",
		"estado",
		"email",
		"telefone",
		"id_account" */
	];

	protected $casts = [
		"nome" => "string",
		/* "razao_social" => "string",
		"cnpj" => "string",
		"endereco" => "string",
		"bairro" => "string",
		"cep" => "string",
		"cidade" => "string",
		"estado" => "string",
		"email" => "string",
		"telefone" => "string", */

		"id_account"=>"integer",
		
		"status"=>StatusEnum::class,
		"id_organizacao"=>"integer",
		"created_at"=>"datetime",
		"id_usuario_criacao"=>"integer",
		"updated_at"=>"datetime",
		"id_usuario_alteracao"=>"integer",
	];

    public function sessionKey(){
        return 'organizacao';
    }

}
