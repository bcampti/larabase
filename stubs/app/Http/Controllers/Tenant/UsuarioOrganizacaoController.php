<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\UserInvitationRequest;
use App\Http\Requests\Tenant\UsuarioOrganizacaoRequest;
use App\Models\Tenant\Organizacao;
use App\Models\Tenant\UserInvitation;
use App\Models\Tenant\UsuarioOrganizacao;
use App\Models\User;
use App\Repositories\Tenant\UsuarioManager;
use App\Repositories\Tenant\UsuarioOrganizacaoManager;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Multitenancy\Models\Tenant;

class UsuarioOrganizacaoController extends Controller
{
    private $usuarioOrganizacaoManager;
	private $usuarioManager;
	
	public function __construct()
	{
		$this->usuarioOrganizacaoManager = new UsuarioOrganizacaoManager();
		$this->usuarioManager = new UsuarioManager();
	}
	
	public function index(Request $request)
    {
		$filtro = $this->usuarioOrganizacaoManager->paginate($request);

		$userInvitations = UserInvitation::orderBy("name","asc")->get();

		return view("usuarioOrganizacao.listar", compact("filtro","userInvitations"));
	}

	public function formulario( UsuarioOrganizacao $usuarioOrganizacao)
    {
		if( old() ){
		    $usuarioOrganizacao->fill(old());
		}
		return view("usuarioOrganizacao.formulario", compact("usuarioOrganizacao"));
	}

	public function edit( $id )
	{
		$usuarioOrganizacao = $this->usuarioOrganizacaoManager->findOrFail($id);
		
		return $this->formulario($usuarioOrganizacao);
	}

	public function update(UsuarioOrganizacaoRequest $request, $id)
    {
		$usuarioOrganizacao = $this->usuarioOrganizacaoManager->findOrFail($id);

		$user = auth()->user();
		$user->update([
			"name"=>$request->name
		]);

		$usuario = $this->usuarioManager->findOrFail($user->id);
		$usuario->update([
			"name"=>$request->name
		]);
		$usuario = $this->usuarioManager->salvar($usuario);
		
		$usuarioOrganizacao->fill($request->validated());

		$usuarioOrganizacao = $this->usuarioOrganizacaoManager->salvar($usuarioOrganizacao);
		
		return redirect(route("usuario.organizacao.edit", [$usuarioOrganizacao->id]))->with(GenericMessage::UPDATE_SUCCESS);
	}
	
	public function destroy($id)
    {
		if( !request()->has("password") || is_empty(request("password")) ){
			return back()->with(GenericMessage::PASSWORD_REQUIRED);
		}
		if( !Hash::check(request("password"), auth()->user()->password) ){
			return back()->with(GenericMessage::PASSWORD_BAD);
		}
		
		$usuarioOrganizacao = $this->usuarioOrganizacaoManager->findOrFail($id);
		
		$this->usuarioOrganizacaoManager->excluir($usuarioOrganizacao->id);

		return redirect(route("usuario.organizacao.index"))->with(GenericMessage::DELETE_SUCCESS);
	}

	public function invitation()
	{
		return view("usuarioOrganizacao.invitation");
	}

	public function storeInvitation(UserInvitationRequest $request)
    {
		$userIntivation = new UserInvitation($request->validated());

		$user = User::where("email", $userIntivation->email)
					->where("id_account", Tenant::current()->id)
					->get();

		if( !is_empty($user) ){
			throw ValidationException::withMessages(['email'=>"Este e-mail possui acesso a outra conta, informe um e-mail diferente."]);
		}

		$usuario = UsuarioOrganizacao::where("id_organizacao", Organizacao::currentId())
						->whereHas('usuario', function($query) use ($userIntivation){
							$query->where("email", $userIntivation->email);
						})->get();

		if( !is_empty($usuario) ){
			throw ValidationException::withMessages(['email'=>"Este e-mail já possui acesso a esta Organização."]);
		}
		
		$userIntivation->id_organizacao = Organizacao::currentId();
		$userIntivation->id_account = Tenant::current()->id;
		$userIntivation->save();

		//$userIntivation->notifyNow();
		
		return redirect(route("usuario.organizacao.index"))->with(GenericMessage::alertMessage("Convite enviado com sucesso!"));
	}

	public function destroyInvitation($id)
    {
		if( !request()->has("password") || is_empty(request("password")) ){
			return back()->with(GenericMessage::PASSWORD_REQUIRED);
		}
		if( !Hash::check(request("password"), auth()->user()->password) ){
			return back()->with(GenericMessage::PASSWORD_BAD);
		}
		
		$userIntivation = UserInvitation::findOrFail($id);
		
		$userIntivation->delete();

		return redirect(route("usuario.organizacao.index"))->with(GenericMessage::successMessage("Convite removido com sucesso!"));
	}

}