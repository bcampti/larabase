<?php

namespace Bcampti\Larabase\Models;

use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Models\Model;
use Bcampti\Larabase\Traits\HasUsuarioAlteracao;
use Bcampti\Larabase\Traits\HasUsuarioCriacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizacao extends Model
{
	use HasUsuarioCriacao;
	use HasUsuarioAlteracao;
	use HasFactory;

    protected $table = "organizacao";

    protected $fillable = [
		"nome",
		"razao_social",
		"cnpj",
		"endereco",
		"bairro",
		"cep",
		"cidade",
		"estado",
		"email",
		"telefone",
		"status",
	];

	protected $casts = [
		"nome" => "string",
		"razao_social" => "string",
		"cnpj" => "string",
		"endereco" => "string",
		"bairro" => "string",
		"cep" => "string",
		"cidade" => "string",
		"estado" => "string",
		"email" => "string",
		"telefone" => "string",
		
		"status"=>StatusEnum::class,
		"id_organizacao"=>"integer",
		"created_at"=>"datetime",
		"id_usuario_criacao"=>"integer",
		"updated_at"=>"datetime",
		"id_usuario_alteracao"=>"integer",
	];
}
