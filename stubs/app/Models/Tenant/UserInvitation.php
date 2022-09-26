<?php

namespace App\Models\Tenant;

use App\Enums\CargoUsuarioEnum;
use Bcampti\Larabase\Models\Account;
use Bcampti\Larabase\Models\Model;
use Bcampti\Larabase\Traits\HasUsuarioCriacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class UserInvitation extends Model
{
	use HasUsuarioCriacao;
	use HasFactory;
	use Notifiable;

    protected $table = "user_invitation";

    protected $fillable = [
		"name",
		"email",
		"cargo",
	];

	protected $casts = [
		"name"=>"string",
		"email"=>"string",
		"cargo"=>CargoUsuarioEnum::class,
		"id_account"=>"integer",
		"id_organizacao"=>"integer",

		"created_at"=>"datetime",
		"id_usuario_criacao"=>"integer",
		"updated_at"=>"datetime",
		"id_usuario_alteracao"=>"integer",
	];

	public function account()
	{
		return $this->belongsTo(Account::class, "id_account");
	}

	public function organizacao()
	{
		return $this->belongsTo(Organizacao::class, "id_organizacao");
	}

}
