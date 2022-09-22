<?php namespace App\Http\Middleware\App;

use Bcampti\Larabase\Enums\CargoUsuarioEnum;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Closure;
use Illuminate\Http\Response;

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
		if ( !UserTypeEnum::SUPORTE->equals(auth()->user()->type) )
		{
			if( !hasPermission($permissao) ) {
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
