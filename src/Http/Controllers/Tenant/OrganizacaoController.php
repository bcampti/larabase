<?php

namespace Bcampti\Larabase\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Bcampti\Larabase\Enums\StatusEnum;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Bcampti\Larabase\Http\Requests\Tenant\OrganizacaoRequest;
use Bcampti\Larabase\Models\Tenant\Organizacao;
use Bcampti\Larabase\Repositories\Tenant\OrganizacaoManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrganizacaoController extends Controller
{
    private $organizacaoManager;
	
	public function __construct()
	{
		$this->organizacaoManager = new OrganizacaoManager();
	}
	
	public function index(Request $request)
    {
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
		
		$organizacao = $this->organizacaoManager->salvar($organizacao);
		
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