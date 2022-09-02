<?php namespace Bcampti\Larabase\Models;

use Bcampti\Larabase\Enums\StatusAccountEnum;
use Bcampti\Larabase\Traits\HasUsuarioAlteracao;
use Bcampti\Larabase\Traits\HasUsuarioCriacao;
use Bcampti\Larabase\Utils\Database;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Account extends Model
{
	use UsesLandlordConnection;
	use HasFactory;

	use HasUsuarioCriacao, HasUsuarioAlteracao;

	protected $table = "account";

	protected $fillable = [
		"name",
		//"domain",
		//"database",
		"status",
		//"repositorio",
    ];

	protected $casts = [
		"name"=>"string",
		"domain"=>"string",
		"database"=>"string",
		"status"=>StatusAccountEnum::class,
	    "repositorio"=>"string",
    ];

	public static function booted()
    {
		static::creating(function($model) {
			$model->status = StatusAccountEnum::NOVA->value;
			$database = new Database();
			$model->database = $database->generateSchemaName();
        });

		static::deleting(fn(Account $model) => $model->deleteDependencies());
    }

	public function deleteDependencies()
	{
		if( !is_empty($this->repositorio) )
		{
			Storage::deleteDirectory($this->repositorio);
		}
	}

}
