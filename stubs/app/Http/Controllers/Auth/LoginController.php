<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Bcampti\Larabase\Larabase;
use Bcampti\Larabase\Models\Account;
use Bcampti\Larabase\Repositories\AccountManager;
use Bcampti\Larabase\Repositories\Tenant\UsuarioOrganizacaoManager;
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
    private $usuarioOrganizacaoManager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');

        $this->accountManager = new AccountManager();
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
        return redirect()->route('home');
    }

    public function accountSelect( $id )
    {
        $account = $this->accountManager->findOrFail($id);

        if( request()->user()->tipo == User::TIPO_SUPORTE ){
            request()->user()->update(['id_account' => $account->id]);
            request()->user()->fresh();
        }
        Session::forget('id_organizacao');
        Session::forget("ensure_valid_tenant_session_tenant_id");
        return redirect(route('auth.account.organizacao.index'));
    }

    public function organizacoes(Request $request)
    {
        $filtro = $this->usuarioOrganizacaoManager->paginate($request);

        if( !Session::has('id_organizacao') && $filtro->items->count()==1 ){
            return redirect(route('auth.account.organizacao.select',$filtro->items[0]->id));
        }
        Session::put('organizacoes_count', $filtro->items->count());
        Session::forget('id_organizacao');
        return view('auth.organizacoes', compact('filtro'));
    }

    public function organizacaoSelect( $id_organizacao )
    {
        $usuarioOrganizacao = $this->usuarioOrganizacaoManager->getUsuarioOrganizacao($id_organizacao);
        Session::put('id_organizacao', $usuarioOrganizacao->organizacao->id);

        return redirect()->intended($this->redirectPath());
    }

    public function logout($message = null)
	{
		Auth::logout();
		request()->session()->invalidate();
		request()->session()->regenerateToken();
		return redirect()->route("login")->withErrors([$message]);
	}

    public function accountNoDatabase()
    {
        return abort(403, "Acesso não autorizado!");
        return view('auth.noDatabase');
    }
}
