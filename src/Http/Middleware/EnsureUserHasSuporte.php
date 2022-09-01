<?php

namespace Bcampti\Larabase\Http\Middleware;

use App\Models\User;
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
        if( auth()->user()->tipo !== User::TIPO_SUPORTE ) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
