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
		if( !$request->session()->has('id_organizacao') || !$request->session()->has("organizacao") ){
			return redirect(route('auth.organizacao.listar'));
		}
		return $next($request);
	}
}
