<?php namespace App\Http\Middleware\App;

use App\Models\User;
use Bcampti\Larabase\Enums\CargoUsuarioEnum;
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
		if ( !CargoUsuarioEnum::SUPORTE->equals(auth()->user()->cargo) )
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
