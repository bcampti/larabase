<?php

namespace Bcampti\Larabase\Repositories;

use App\Models\User;
use App\Enums\CargoUsuarioEnum;
use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Bcampti\Larabase\Filtro\AccountFiltro;
use Bcampti\Larabase\Models\Account;
use App\Models\Tenant\Organizacao;
use App\Models\Tenant\Usuario;
use App\Models\Tenant\UsuarioOrganizacao;
use Bcampti\Larabase\Repositories\PaginateInterface;
use App\Repositories\Tenant\OrganizacaoManager;
use App\Repositories\Tenant\UsuarioManager;
use App\Repositories\Tenant\UsuarioOrganizacaoManager;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Bcampti\Larabase\Repositories\TenantManager;
use Bcampti\Larabase\Utils\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AccountManager extends TenantManager implements PaginateInterface
{
	protected $class_model = Account::class;

	public function paginate(Request $request)
	{
	    $filtro = new AccountFiltro($request);
	    
		$query = $this->getQuery($filtro->account);
		
		$query->when($filtro->search, function ($query) use ($filtro) {
			$query->where(function($q) use ($filtro) {
				$q->whereRaw("lower(name) like '".strLower($filtro->search)."%'");
					//->orWhere("status", "like", strLower($filtro->search)."%");
			});
		});
		
		$filtro->setTotal($query->count());
		
		if( !empty($filtro->orderBy) ){
			$query->orderBy( $filtro->orderBy, $filtro->direcao );
		}
		if( $filtro->orderBy != "id" ){
		    $query->orderBy("id");
		}
		$query->offset($filtro->inicio)->limit( $filtro->limit )
				->select($this->newInstance()->getTable().".*");
		
		$filtro->setItems($query->get());
		
		return $filtro;
	}

	public function createDatabase(Account $account):Account
	{
        $database = new Database();
		if( is_empty($account->database) ){
			$account->database = $database->generateSchemaName();
			$this->salvar($account);
        }

        if( $database->schemaExists($account->database) ){
			if( UserTypeEnum::SUPORTE->equals(auth()->user()->type->value) ){
				throw new GenericMessage("A base de dados já esta criada");
			}
            return $account;
        }

		$database = new Database();
        $database->createSchema($account->database);
        
        Artisan::call('migrate:tenant --tenant='.$account->id);
        
	    return $this->salvar($account);
	}
	
	public function adicionarDadosPadraoNovaConta( User $user, Account $account )
	{
		/* CRIA O REPOSITORIO DA COMPANHIA */
		if( is_empty($account->repositorio) )
		{
			//$this->criarRepositorioCompanhia($account);
		}

		$account->makeCurrent();

		/* ADICIONA USUARIO AO SCHEMA */
	    $usuario = new Usuario();
	    $usuario->id = $user->id;
	    $usuario->name = $user->name;
	    $usuario->email = $user->email;
	    $usuario->password = $user->password;

		$usuarioManager = new UsuarioManager();
	    $usuarioManager->salvar($usuario);
	    
		// ADICIONA ORGANIZACAO
	    $organizacao = new Organizacao();
	    $organizacao->id_account = $account->id;
	    $organizacao->nome = $account->name;
		$organizacao->id_usuario_criacao = $usuario->id;
		$organizacao->status = StatusEnum::ATIVO;

	    $organizacaoManager = new OrganizacaoManager();
	    $organizacao = $organizacaoManager->salvar($organizacao);

		$usuarioOrganizacao = new UsuarioOrganizacao();
		$usuarioOrganizacao->id_usuario = $usuario->id;
		$usuarioOrganizacao->id_organizacao = $organizacao->id;
		$usuarioOrganizacao->cargo = CargoUsuarioEnum::ADMIN->value;
		$usuarioOrganizacao->id_usuario_criacao = $usuario->id;

		$usuarioOrganizacaoManager = new UsuarioOrganizacaoManager();
		$usuarioOrganizacaoManager->salvar($usuarioOrganizacao);

		//$organizacaoManager->adicionarDadosPadraoOrganizacao($organizacao, $usuario, $account);
	}

}