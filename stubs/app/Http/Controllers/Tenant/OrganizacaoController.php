<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Exceptions\GenericMessage;
use App\Http\Requests\Tenant\OrganizacaoRequest;
use App\Models\Tenant\Organizacao;
use App\Models\Tenant\UsuarioOrganizacao;
use App\Repositories\Tenant\OrganizacaoManager;
use App\Repositories\Tenant\UsuarioOrganizacaoManager;
use Bcampti\Larabase\Enums\CargoUsuarioEnum;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Multitenancy\Models\Tenant;

class OrganizacaoController extends Controller
{
    private $organizacaoManager;
	
	public function __construct()
	{
		$this->organizacaoManager = new OrganizacaoManager();
	}
	
	public function index(Request $request)
    {
		if( !UserTypeEnum::SUPORTE->equals(auth()->user()->type->value) ){
			return redirect(route('auth.account.organizacao.index'));
		}
		$filtro = $this->organizacaoManager->paginate($request);

		return view("organizacao.listar", compact("filtro"));
	}

	public function formulario( Organizacao $organizacao)
    {
		if( old() ){
		    $organizacao->fill(old());
		}
		return view("organizacao.formulario", compact("organizacao"));
	}

	public function create()
	{
		$organizacao = new Organizacao();
		$organizacao->status = StatusEnum::ATIVO;

		return $this->formulario($organizacao);
	}

	public function store(OrganizacaoRequest $request)
    {
		$organizacao = new Organizacao($request->validated());
		$organizacao->id_account = Tenant::current()->id;

		$organizacao = $this->organizacaoManager->salvar($organizacao);

		if( UserTypeEnum::PROPRIETARIO->equals(auth()->user()->type->value) )
		{
			$usuarioOrganizacao = new UsuarioOrganizacao();
			$usuarioOrganizacao->id_usuario = auth()->user()->id;
			$usuarioOrganizacao->id_organizacao = $organizacao->id;
			$usuarioOrganizacao->cargo = CargoUsuarioEnum::ADMIN->value;
			$usuarioOrganizacao->id_usuario_criacao = auth()->user()->id;

			$usuarioOrganizacaoManager = new UsuarioOrganizacaoManager();
			$usuarioOrganizacaoManager->salvar($usuarioOrganizacao);
		}
		return redirect(route("organizacao.edit", [$organizacao->id]))->with(GenericMessage::INSERT_SUCCESS);
	}

	public function edit( $id )
	{
		$organizacao = $this->organizacaoManager->findOrFail($id);
		
		return $this->formulario($organizacao);
	}

	public function update(OrganizacaoRequest $request, $id)
    {
		$organizacao = new Organizacao();
		$organizacao = $this->organizacaoManager->findOrFail($id);
		$organizacao->fill($request->validated());

		$organizacao = $this->organizacaoManager->salvar($organizacao);
		
		return redirect(route("organizacao.edit", [$organizacao->id]))->with(GenericMessage::UPDATE_SUCCESS);
	}
	
	public function destroy($id)
    {
		if( !request()->has("password") || is_empty(request("password")) ){
			return back()->with(GenericMessage::PASSWORD_REQUIRED);
		}
		if( !Hash::check(request("password"), auth()->user()->password) ){
			return back()->with(GenericMessage::PASSWORD_BAD);
		}
		
		$organizacao = $this->organizacaoManager->findOrFail($id);
		
		$this->organizacaoManager->excluir($organizacao->id);

		return redirect(route("organizacao.index"))->with(GenericMessage::DELETE_SUCCESS);
	}

}