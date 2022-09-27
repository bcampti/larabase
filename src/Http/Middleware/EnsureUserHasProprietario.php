<?php

namespace Bcampti\Larabase\Http\Middleware;

use Bcampti\Larabase\Enums\UserTypeEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUserHasProprietario
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
        if( haspro !UserTypeEnum::PROPRIETARIO->equals(auth()->user()->type->value) ) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
