<?php namespace Bcampti\Larabase\Repositories\Core;

use Bcampti\Larabase\Scopes\OrganizacaoScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class TenantManager 
{
	/**
	 * class_model
	 *
	 * @var mixed
	 */
	protected $class_model;
		
	protected function newInstance()
	{
		return app($this->class_model);
	}
	
	public function salvar( $model )
	{
		$model->normalizeFields();
		$model->save();
		return $model;
	}

	public function findOrFail($id)
	{
		if( empty($id) ){
			throw new ModelNotFoundException("O registro não existe ou não pode ser localizado");
		}
		return $this->newInstance()->whereKey( $id )->firstOrFail();
	}

	/**
	 * @param Integer $id
	 * @return \Illuminate\Database\Eloquent\Model|object|null
	 */
	public function getById($id)
	{
		if( empty($id) ){
			throw new ModelNotFoundException("O registro não existe ou não pode ser localizado");
		}
		return $this->newInstance()->whereKey( $id )->first();
	}
	
	/**
	 * @param {Model} $model
	 * @param String $orderBy
	 * @return \\Lista de registro Collection[Model]
	 */
	public function findByOtherFields( $model = null, $orderBy = null ) 
	{
		return $this->montaQuery( $model, $orderBy )->get();
	}
	
	/**
	 * @param {Model} $model
	 * @param String $orderBy
	 * @return \\Lista de registro Collection[Model]
	 */
	public function count( $model = null ):int
	{
		return $this->montaQuery( $model )->count();
	}
	
	/**
	 * Retornara object Builder configurado com a consulta, para executar utilize a opção adequada para o seu retorno.
	 * Com o Builder é possivel utilizar 'join' function
	 * Ex.:
	 * 		$query->paginate();
	 * 		$query->get();
	 * 		$query->first();
	 * 		$query->count();
	 * 
	 * @param $model Model|TenantModel
	 * @param String orderBy ex.: campo desc
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function getQuery( $model = null, $orderBy = null ):Builder
	{
		return $this->montaQuery( $model, $orderBy );
	}
	
	/**
	 * @param {Model} $model
	 * @param String $orderBy
	 * @return \Illuminate\Database\Eloquent\Builder Builder para ser executado
	 */
	protected function montaQuery( $model = null, $orderBy = null ):Builder
	{
		if( is_null($model) ){
			$model = $this->newInstance();
		}
		$enableOrganizacaoScope = optional($model)->enableOrganizacaoScope;
		$query = $model->newQuery();
		if( $enableOrganizacaoScope ){
			$query->withoutGlobalScope(OrganizacaoScope::class);
			$query->where($model->getTable().'.id_organizacao', session("id_organizacao"));
		}

		if( !is_null($model) )
		{
			foreach ( $model->getAttributes() as $key => $value )
			{
				if( $key == "id_organizacao" && $enableOrganizacaoScope ){
					continue;
				}
				if( !is_null($value) )
				{
					switch( trim(strLower($model->getCasts()[$key])) )
					{
						case "string":
						case "text":
							if( !empty($value) ){
								if( in_array($key, ["senha","login","id"]) ){
									$query->whereRaw($model->getTable().".".$key. " = '".tratarCaracteresEspeciais($value)."'" );
								}else{
									$query->whereRaw("LOWER(".$model->getTable().".".$key.") like '".normalizeString($value)."%'");
								}
							}
							break;
							
						case "uuid" :
							if( !empty($value) ){
								$query->where($model->getTable().".".$key, "=","".$value."");
							}
							break;
						
						case "boolean":
						case "real":
						case "float":
						case "double":
						case "int":
						case "integer":
							$query->where($model->getTable().".".$key, "=", $value);
							break;
							
						default:
							if( !empty($value) ){
								if( $value instanceof \UnitEnum){
									$query->where($model->getTable().".".$key, "=", $value->value);
								}else{
									$query->where($model->getTable().".".$key, "=", addslashes($value));
								}
							}
							break;
					}
				}
			}
		}
		if( !is_null($orderBy) ){
			$query->orderByRaw( $orderBy );
		}
		return $query;
	}
	
	public function excluirModel( $model ) 
	{
		DB::transaction(function() use ($model) {
			$model->delete();
		});
		return true;
	}

	public function excluir( $id )
	{
		$model = $this->findOrFail($id);
		return $this->excluirModel($model);
	}

	public function searchQuery(Request $request)
	{
		$query = $this->getQuery();
		if( !is_empty($request->codigo) ){
			$query->where("id", $request->codigo);
		}
		if( !is_empty($request->descricao) ){
			$query->whereRaw("lower(nome) like '".normalizeString($request->descricao)."%'");
		}
		return $query->limit(10);
	}
	
}
