<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Bcampti\Larabase\Larabase;
use Bcampti\Larabase\Models\Account;
use Bcampti\Larabase\Repositories\AccountManager;
use Bcampti\Larabase\Repositories\Tenant\OrganizacaoManager;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');

        $this->accountManager = new AccountManager();
        $this->organizacaoManager = new OrganizacaoManager();
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
        Session::forget('id_organizacao');
        Session::forget("ensure_valid_tenant_session_tenant_id");
        $account = $this->accountManager->findOrFail($id);

        if( request()->user()->tipo == User::TIPO_SUPORTE ){
            request()->user()->update(['id_account' => $account->id]);
            request()->user()->fresh();
        }
        return redirect(route('auth.account.organizacao.index'));
    }

    public function organizacoes(Request $request)
    {
        Session::forget('id_organizacao');
        $filtro = $this->organizacaoManager->paginate($request);
        return view('auth.organizacoes', compact('filtro'));
    }

    public function organizacaoSelect( $id )
    {
        $organizacao = $this->organizacaoManager->findOrFail($id);
        Session::put('id_organizacao', $organizacao->id);

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
