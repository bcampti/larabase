<?php

namespace Bcampti\Larabase\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use OwenIt\Auditing\Contracts\Auditable;

class Model extends EloquentModel implements Auditable
{
	use \OwenIt\Auditing\Auditable;

	/** campos que não serão auditados */
	protected $auditExclude = ['id_usuario_criacao','id_usuario_alteracao','data_criacao','data_alteracao'];
	/** quais eventos serão registrados */
	protected $auditEvents = ['created', 'updated', 'deleted', 'restored',];

	 /**
     * Attribute modifiers.
     *
     * @var array
     */
    /* protected $attributeModifiers = [
        'title' => LeftRedactor::class,
		'title' => RightRedactor::class,
		'title' => Base64Encoder::class,
    ]; */

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

	/* const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at'; */

}
