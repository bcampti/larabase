<?php

namespace Bcampti\Larabase\Models\Tenant;

use Bcampti\Larabase\Enums\StatusUsuarioEnum;
use Bcampti\Larabase\Models\Model;
use Bcampti\Larabase\Traits\HasUsuarioAlteracao;
use Bcampti\Larabase\Traits\HasUsuarioCriacao;
use Illuminate\Support\Facades\Session;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class UsuarioOrganizacao extends Model
{
    use UsesTenantConnection;
	use HasUsuarioCriacao;
	use HasUsuarioAlteracao;
    
    protected $table = "usuario_organizacao";

    protected $fillable = [
        "id_usuario",
        "id_organizacao",
        "tipo",
        "status"
    ];

    protected $casts = [
        "id_usuario"=>"integer",
        "id_organizacao"=>"integer",
        "tipo"=>"string",
        
        "status"=>StatusUsuarioEnum::class,
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


    public static function containerKey(){
        return 'loginTenant';
    }

    public function makeCurrent(): static
    {
        if ($this->isCurrent()) {
            return $this;
        }

        static::forgetCurrent();

        Session::put(static::containerKey(), $this);
        Session::put('id_organizacao', $this->organizacao->id);

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