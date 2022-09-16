<?php

namespace Bcampti\Larabase\Http\Middleware;

use App\Models\Tenant\Organizacao;
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
		if( !Organizacao::checkCurrent() ){
			return redirect(route('auth.account.organizacao.index'));
		}

		return $next($request);
	}
}
