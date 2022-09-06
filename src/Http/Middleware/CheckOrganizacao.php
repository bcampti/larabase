<?php

namespace Bcampti\Larabase\Http\Middleware;

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
		if( !session()->has('id_organizacao') ){
			return redirect(route('auth.account.organizacao.index'));
		}
		return $next($request);
	}
}
