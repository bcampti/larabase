<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Bcampti\Larabase\Larabase;
use Bcampti\Larabase\Models\Account;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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

    public function accounts( Request $request )
    {
        if( auth()->user()->tipo !== User::TIPO_SUPORTE ){
            return abort(403, "Acesso não autorizado!");
        }

        $accounts = Account::get();

        return view('auth.accounts', compact('accounts'));
    }

    public function accountSelect( $id )
    {
        $account = Account::findOrFail($id);

        $user = request()->user();

        if( $user->tipo == User::TIPO_SUPORTE )
        {
            $user->id_account = $account->id;
            $user->save();
        }

        return redirect(route('auth.account.organizacao.index'));
    }

    public function organizacoes(Request $request)
    {
        $organizacao = Larabase::getOrganizacaoModel();
        $organizacao = $organizacao->first();
        
        return redirect()->route('auth.account.organizacao.select', $organizacao->id);

        return view('auth.organizacoes');
    }

    public function organizacaoSelect( $id )
    {
        $organizacao = Larabase::getOrganizacaoModel();
        $organizacao = $organizacao->find($id);
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
