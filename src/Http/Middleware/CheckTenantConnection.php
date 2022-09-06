<?php

namespace Bcampti\Larabase\Http\Middleware;

use App\Models\User;
use Bcampti\Larabase\Utils\Database;
use Closure;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;

class CheckTenantConnection
{
	use UsesTenantModel;

    public function handle($request, Closure $next)
    {
		if( auth()->user()->tipo == User::TIPO_SUPORTE ) {
			return redirect(route('auth.account.index'));
		}

		$tenant = auth()->user()->account;
		if( is_empty($tenant) ){
			return redirect(route("auth.account.no.database"));
		}
		
		if( !(new Database())->schemaExists($tenant->getDatabaseName()) ){
			return redirect(route("auth.account.no.database"));
		}
		
		$tenant->makeCurrent();

		return $next($request);
	}
}
