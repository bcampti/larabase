<?php

namespace Bcampti\Larabase\Http\Middleware;

use Bcampti\Larabase\Models\Tenant\UsuarioOrganizacao;
use Closure;

class CheckOrganizacao
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if( !UsuarioOrganizacao::checkCurrent() ){
			return redirect(route('auth.account.organizacao.index'));
		}

		return $next($request);
	}
}
