<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Bcampti\Larabase\Enums\CargoUsuarioEnum;
use App\Models\Tenant\Organizacao;
use Bcampti\Larabase\Repositories\AccountManager;
use App\Repositories\Tenant\OrganizacaoManager;
use App\Repositories\Tenant\UsuarioOrganizacaoManager;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private $accountManager;
    private $organizacaoManager;
    private $usuarioOrganizacaoManager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware("guest")->except("logout");

        $this->accountManager = new AccountManager();
        $this->organizacaoManager = new OrganizacaoManager();
        $this->usuarioOrganizacaoManager = new UsuarioOrganizacaoManager();
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route("home");
    }

    public function accountSelect( $id )
    {
        $account = $this->accountManager->findOrFail($id);

        if( CargoUsuarioEnum::SUPORTE->equals(request()->user()->cargo) ){
            request()->user()->update(["id_account" => $account->id]);
            request()->user()->fresh();
        }
        Session::forget("ensure_valid_tenant_session_tenant_id");
        Organizacao::forgetCurrent();

        return redirect(route("auth.account.organizacao.index"));
    }

    public function organizacoes(Request $request)
    {
        $filtro = $this->organizacaoManager->getOrganizacoesComAcesso($request);

        if( Organizacao::checkCurrent() ){
			$filtro->filtroAtivo = true;
		}
        $disponiveis = $filtro->items->count();

        Organizacao::forgetCurrent();

        if( $disponiveis == 1 && !$filtro->filtroAtivo ){
            return redirect(route("auth.account.organizacao.select", $filtro->items[0]->id));
        }

        return view("auth.organizacoes", compact("filtro"));
    }

    public function organizacaoSelect( $id_organizacao )
    {
        if( CargoUsuarioEnum::SUPORTE->equals(request()->user()->cargo) )
        {
            $organizacao = $this->organizacaoManager->findOrFail($id_organizacao);
            $organizacao->makeCurrent();
        }
        else
        {
            $usuarioOrganizacao = $this->usuarioOrganizacaoManager->getUsuarioOrganizacao($id_organizacao);
            $usuarioOrganizacao->organizacao->makeCurrent();
        }
        return redirect()->intended($this->redirectPath());
    }

    public function logout($message = null)
	{
        if( auth()->check() && CargoUsuarioEnum::SUPORTE->equals(auth()->user()->cargo) ){
            auth()->user()->update(['id_account'=>null]);
        }
		Auth::logout();
		request()->session()->invalidate();
		request()->session()->regenerateToken();
		return redirect()->route("login")->withErrors([$message]);
	}

    public function accountNoDatabase()
    {
        return view("auth.noDatabase");
    }
}
