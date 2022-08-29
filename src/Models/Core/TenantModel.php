<?php

namespace Bcampti\Larabase\Models\Core;

use Illuminate\Support\Str;
use Normalizer;

class Model extends Model
{
	const STATUS_ATIVO = 'Ativo';
	const STATUS_INATIVO = 'Inativo';

	/**
     * Indicates if the model should be timestamped.
     * @var bool
     */
	public $timestamps = true;
	
	/**
     * The storage format of the model's date columns.
     * @var string
     */
    //protected $dateFormat = 'U';

	/* const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_alteracao'; */
		
	/**
	 * normalizeFields
	 * 
	 * verifica e padroniza os tipos de dados para cada campo
	 *
	 * @return void
	 */
	public function normalizeFields()
	{
		foreach( $this->getFillable() as $campo )
		{
			if( empty($this->{$campo}) && $campo!="id" )
			{
				if( $this->hasCast($campo))
				{
					switch( $this->getCasts()[$campo] )
					{
						case "string":
						case "uuid" :
							$this->{$campo} = null;
							break;
						case "boolean":
							$this->{$campo} = false;
							break;
						case "float":
						case "real":
						case "double":
							$this->{$campo} = 0;
							break;
						case "integer":
							if( Str::startsWith($campo, "id_") ){
								$this->{$campo} = null;
							}else{
								$this->{$campo} = 0;
							}
							break;
						default:
							$this->{$campo} = null;
							break;
					}
				}else{
					$this->{$campo} = null;
				}
			}else{
				if( $this->hasCast($campo))
				{
					switch( $this->getCasts()[$campo] )
					{
						/* campo string recebe tratamento para remoção de formatação de fonte */
						case "string":
							$this->{$campo} = Normalizer::normalize($this->{$campo}, Normalizer::NFKC);
							break;
					}
				}
			}
		}
		return $this;
	}
	
}
