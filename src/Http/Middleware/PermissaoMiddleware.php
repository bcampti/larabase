<?php namespace App\Http\Middleware\App;

use App\Models\User;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class PermissaoMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, ...$permissao)
	{
		if ( auth()->user()->tipo != User::TIPO_SUPORTE )
		{
			if( !acessoLiberado($permissao) ) {
				if ($request->ajax ()) {
					$msg['mensagem']['tipo'] = 'erro';
					$msg['mensagem']['titulo'] = 'Atenção!';
					$msg['mensagem']['mensagem'] = 'Acesso não permitido!';
					return response()->json($msg);
				}else{
					abort(Response::HTTP_UNAUTHORIZED);
				}
			}
		}
		return $next($request);
	}
}
