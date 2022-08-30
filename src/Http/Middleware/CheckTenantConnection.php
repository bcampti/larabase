<?php

namespace Bcampti\Larabase\Http\Middleware;

use Bcampti\Larabase\Utils\Database\Database;
use Closure;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;

class CheckTenantConnection
{
	use UsesTenantModel;

    public function handle($request, Closure $next)
    {
        if( !$this->getTenantModel()::checkCurrent()) {
			return redirect(route('auth.tenant.listar'));
		}
		$tenant = $this->getTenantModel()::current();
		if( !(new Database())->schemaExists($tenant->getDatabaseName()) ){
			return redirect(route("auth.tenant.no.database"));
		}
		$tenant->makeCurrent();

		return $next($request);
	}
}
