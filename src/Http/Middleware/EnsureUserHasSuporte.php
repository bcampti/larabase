<?php

namespace Bcampti\Larabase\Http\Middleware;

use Bcampti\Larabase\Enums\CargoUsuarioEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUserHasSuporte
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( !CargoUsuarioEnum::SUPORTE->equals(auth()->user()->cargo) ) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
