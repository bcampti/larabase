<?php

namespace App\Models\Tenant;

use App\Enums\CargoUsuarioEnum;
use Bcampti\Larabase\Models\Model;
use Bcampti\Larabase\Traits\HasUsuarioAlteracao;
use Bcampti\Larabase\Traits\HasUsuarioCriacao;
use Bcampti\Larabase\Traits\KeepOnSession;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class UsuarioOrganizacao extends Model
{
    use UsesTenantConnection;
	use HasUsuarioCriacao;
	use HasUsuarioAlteracao;
    use KeepOnSession;
    
    protected $table = "usuario_organizacao";

    protected $fillable = [
        "id_usuario",
        "id_organizacao",
        "cargo",
    ];

    protected $casts = [
        "id_usuario"=>"integer",
        "id_organizacao"=>"integer",
        "cargo"=>CargoUsuarioEnum::class,
        
		"created_at"=>"datetime",
		"id_usuario_criacao"=>"integer",
		"updated_at"=>"datetime",
		"id_usuario_alteracao"=>"integer",
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function organizacao(){
        return $this->belongsTo(Organizacao::class, 'id_organizacao');
    }

}