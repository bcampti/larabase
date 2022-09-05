<?php

namespace Bcampti\Larabase\Repositories;

use App\Models\User;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Bcampti\Larabase\Filtro\AccountFiltro;
use Bcampti\Larabase\Models\Account;
use Bcampti\Larabase\Models\Tenant\Organizacao;
use Bcampti\Larabase\Models\Tenant\Usuario;
use Bcampti\Larabase\Repositories\PaginateInterface;
use Bcampti\Larabase\Repositories\TenantManager;
use Bcampti\Larabase\Utils\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class AccountManager extends TenantManager implements PaginateInterface
{
	protected $class_model = Account::class;

	public function paginate(Request $request)
	{
	    $filtro = new AccountFiltro($request);
	    
		$query = $this->getQuery($filtro->account);
		
		$query->when($filtro->search, function ($query) use ($filtro) {
			$query->where(function($q) use ($filtro) {
				$q->whereRaw("lower(name) like '".Str::lower($filtro->search)."%'");
					//->orWhere("status", "like", Str::lower($filtro->search)."%");
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
			if( auth()->user()->tipo == User::TIPO_SUPORTE ){
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
	    $usuario->nome = $user->nome;
	    $usuario->email = $user->email;
	    $usuario->password = $user->password;
	    $usuario->status = $user->status;
	    $usuario->tipo = $user->tipo;
	    $usuario->data_ultimo_login = $user->data_ultimo_login;
	    $usuario->data_criacao = $user->data_criacao;
	    $usuario->idioma = $user->idioma;
	    
	    $usuario->save();
	    
		// ADICIONA ORGANIZACAO
	    $organizacao = new Organizacao();
	    $organizacao->id_account = $account->id;
	    $organizacao->nome = $account->name;
		$organizacao->id_usuario_criacao = $usuario->id;

	    $organizacaoManager = new OrganizacaoManager();
	    $organizacao = $organizacaoManager->salvar($organizacao);

		//$organizacaoManager->adicionarDadosPadraoOrganizacao($organizacao, $usuario, $account);
	}

}