<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\UsuarioPasswordRequest;
use App\Http\Requests\Tenant\UsuarioUpdateRequest;
use App\Repositories\Tenant\UsuarioManager;
use Bcampti\Larabase\Exceptions\GenericMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    private $usuarioManager;
	
	public function __construct()
	{
		$this->usuarioManager = new UsuarioManager();
	}

	public function perfil()
    {
		$user = auth()->user()->fresh();

		return view("usuario.perfil", compact("user"));
	}

	public function update(UsuarioUpdateRequest $request)
    {
		$user = auth()->user();
		$user->update($request->validated());

		$usuario = $this->usuarioManager->findOrFail($user->id);
		$usuario->fill($request->validated());

		$usuario = $this->usuarioManager->salvar($usuario);
		
		return redirect(route("usuario.perfil"))->with(GenericMessage::successMessage("Perfil Atualizado"));
	}

	public function updatePassword(UsuarioPasswordRequest $request)
    {
		if( !$request->has('current_password') || is_empty($request->current_password) ){
			throw ValidationException::withMessages(["current_password" => trans('validation.required',['attribute'=>'Senha Atual'])]);
		}

		$user = auth()->user();

		if( !Hash::check($request->current_password, $user->password) ){
			throw ValidationException::withMessages(["current_password" => trans('auth.password')]);
		}

		$user->password = Hash::make($request->password);
		$user->save();

		$usuario = $this->usuarioManager->findOrFail($user->id);
		$usuario->password = $user->password;

		$usuario = $this->usuarioManager->salvar($usuario);

		return redirect(route("usuario.perfil"))->with(GenericMessage::successMessage("Senha Atualizada"));
	}
}