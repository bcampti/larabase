<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\UserInvitationRequest;
use App\Http\Requests\Tenant\UsuarioOrganizacaoRequest;
use App\Models\Tenant\Organizacao;
use App\Models\Tenant\UserInvitation;
use App\Models\Tenant\Usuario;
use App\Models\Tenant\UsuarioOrganizacao;
use App\Models\User;
use App\Notifications\Tenant\UserInvitationNotification;
use App\Repositories\Tenant\UsuarioManager;
use App\Repositories\Tenant\UsuarioOrganizacaoManager;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
		$userInvitation = new UserInvitation($request->validated());

		$user = User::where("email", $userInvitation->email)
					->where("id_account", Tenant::current()->id)
					->get();

		if( !is_empty($user) ){
			throw ValidationException::withMessages(['email'=>"Este e-mail possui acesso a outra conta, informe um e-mail diferente."]);
		}

		$usuario = UsuarioOrganizacao::where("id_organizacao", Organizacao::currentId())
						->whereHas('usuario', function($query) use ($userInvitation){
							$query->where("email", $userInvitation->email);
						})->get();

		if( !is_empty($usuario) ){
			throw ValidationException::withMessages(['email'=>"Este e-mail já possui acesso a esta Organização."]);
		}
		
		$userInvitation->id_organizacao = Organizacao::currentId();
		$userInvitation->id_account = Tenant::current()->id;
		$userInvitation->save();

		$userInvitation->notifyNow(new UserInvitationNotification($userInvitation));
		
		return redirect(route("usuario.organizacao.index"))->with(GenericMessage::alertMessage("Convite enviado com sucesso!"));
	}

	public function sendInvitation( UserInvitation $userInvitation )
	{
		$userInvitation->notifyNow(new UserInvitationNotification($userInvitation));

		return redirect(route('usuario.organizacao.index'))->with(GenericMessage::alertMessage("Convite reenviado com sucesso!"));
	}

	public function destroyInvitation($id)
    {
		if( !request()->has("password") || is_empty(request("password")) ){
			return back()->with(GenericMessage::PASSWORD_REQUIRED);
		}
		if( !Hash::check(request("password"), auth()->user()->password) ){
			return back()->with(GenericMessage::PASSWORD_BAD);
		}
		
		$userInvitation = UserInvitation::findOrFail($id);
		
		$userInvitation->delete();

		return redirect(route("usuario.organizacao.index"))->with(GenericMessage::successMessage("Convite removido com sucesso!"));
	}

	public function aceitarConvite( UserInvitation $userInvitation )
	{
		if( auth()->check() && auth()->user()->email != $userInvitation->email ){
			return redirect(route("home"))->with(GenericMessage::alertMessage("Existe um Usuário conectado neste navegador, para aceitar o convite desconecte desta conta."));
		}
		$user = User::where('email', $userInvitation->email)->first();

		if( is_empty($user) ){
			return view('usuarioOrganizacao.convite', compact('userInvitation'));
		}

		$userInvitation->account->makeCurrent();
		$organizacao = $userInvitation->organizacao;

		/* ADICIONA USUARIO AO SCHEMA */
	    $usuario = new Usuario();
	    $usuario->id = $user->id;
	    $usuario->name = $user->name;
	    $usuario->email = $user->email;
	    $usuario->password = $user->password;

		$usuarioManager = new UsuarioManager();
	    $usuarioManager->salvar($usuario);
		
		$usuarioOrganizacao = new UsuarioOrganizacao();
		$usuarioOrganizacao->id_usuario = $usuario->id;
		$usuarioOrganizacao->id_organizacao = $organizacao->id;
		$usuarioOrganizacao->cargo = $userInvitation->cargo->value;
		$usuarioOrganizacao->id_usuario_criacao = $usuario->id;

		$usuarioOrganizacaoManager = new UsuarioOrganizacaoManager();
		$usuarioOrganizacaoManager->salvar($usuarioOrganizacao);

		$userInvitation->delete();

		return redirect(route('auth.account.organizacao.index'));
	}
	
	public function adicionarUsuario(Request $request)
	{
		$inputs = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
			'invitation' => ['required','exists:user_invitation,id']
        ],
        [
            'terms.required' => 'Você deve aceitar os Termos e Políticas de Privacidade',
            'terms.accepted' => 'Você deve aceitar os Termos e Políticas de Privacidade',
        ])->validate();

		$userInvitation = UserInvitation::findOrFail($inputs['invitation']);
		
		$user = User::create([
			'name' => $inputs['name'],
			'email' => $userInvitation->email,
			'password' => Hash::make($inputs['password']),
			'type' => UserTypeEnum::USUARIO->value,
			'id_account'=>$userInvitation->id_account,
		]);

		if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

		if (Auth::attempt(['email' => $user->email, 'password' => $inputs['password']])) {
			return back();
		}
		return redirect(route('login'));
	}
}