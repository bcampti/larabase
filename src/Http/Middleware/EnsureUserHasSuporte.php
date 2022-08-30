<?php

namespace App\Http\Middleware\App;

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
        if( $request->user()->tipo !== User::TIPO_SUPORTE ) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
