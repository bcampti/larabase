<?php

namespace App\Models\Tenant;

use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Models\Model;
use Bcampti\Larabase\Traits\HasUsuarioAlteracao;
use Bcampti\Larabase\Traits\HasUsuarioCriacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Organizacao extends Model
{
	use UsesTenantConnection;
	use HasUsuarioCriacao;
	use HasUsuarioAlteracao;
	use HasFactory;

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


    public static function containerKey(){
        return 'organizacao';
    }

    public function makeCurrent(): static
    {
        if ($this->isCurrent()) {
            return $this;
        }

        static::forgetCurrent();

        Session::put(static::containerKey(), $this);
        Session::put('id_organizacao', $this->id);

        return $this;
    }

    public function forget(): static
    {
        Session::forget(static::containerKey());
        Session::forget('id_organizacao');

        return $this;
    }

    public static function current(): ?static
    {
        if (!Session::has(static::containerKey())) {
            return null;
        }

        return Session::get(static::containerKey());
    }

    public static function checkCurrent(): bool
    {
        return static::current() !== null;
    }

    public function isCurrent(): bool
    {
        return static::current()?->getKey() === $this->getKey();
    }

    public static function forgetCurrent()
    {
        $currentTenant = static::current();

        if (is_null($currentTenant)) {
            return null;
        }

        $currentTenant->forget();

        return $currentTenant;
    }
}
