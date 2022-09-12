<?php

namespace Bcampti\Larabase\Http\Controllers;

use App\Http\Controllers\Controller;
use Bcampti\Larabase\Enums\StatusAccountEnum;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Bcampti\Larabase\Http\Requests\AccountRequest;
use Bcampti\Larabase\Models\Account;
use Bcampti\Larabase\Repositories\AccountManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    private $accountManager;
	
	public function __construct()
	{
		$this->accountManager = new AccountManager();
	}
	
	public function index(Request $request)
    {
		$filtro = $this->accountManager->paginate($request);

		return view("account.listar", compact("filtro"));
	}

	public function formulario( Account $account)
    {
		if( old() ){
		    $account->fill(old());
		}
		return view("account.formulario", compact("account"));
	}

	public function create()
	{
		$account = new Account();
		$account->status = StatusAccountEnum::ATIVO;

		return $this->formulario($account);
	}

	public function store(AccountRequest $request)
    {
		$account = new Account($request->validated());
		
		$account = $this->accountManager->salvar($account);
		
		return redirect(route("account.edit", [$account->id]))->with(GenericMessage::INSERT_SUCCESS);
	}

	public function edit( $id )
	{
		$account = $this->accountManager->findOrFail($id);
		
		return $this->formulario($account);
	}

	public function update(AccountRequest $request, $id)
    {
		$account = new Account();
		$account = $this->accountManager->findOrFail($id);
		$account->fill($request->validated());

		$account = $this->accountManager->salvar($account);
		
		return redirect(route("account.edit", [$account->id]))->with(GenericMessage::UPDATE_SUCCESS);
	}
	
	public function destroy($id)
    {
		if( !request()->has("password") || is_empty(request("password")) ){
			return back()->with(GenericMessage::PASSWORD_REQUIRED);
		}
		if( !Hash::check(request("password"), auth()->user()->password) ){
			return back()->with(GenericMessage::PASSWORD_BAD);
		}
		
		$account = $this->accountManager->findOrFail($id);
		
		$this->accountManager->excluir($account->id);

		return redirect(route("account.index"))->with(GenericMessage::DELETE_SUCCESS);
	}

}