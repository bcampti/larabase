<?php

namespace Bcampti\Larabase\Http\Middleware;

use Bcampti\Larabase\Utils\Database;
use Closure;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;

class CheckTenantConnection
{
	use UsesTenantModel;

    public function handle($request, Closure $next)
    {
        if( !$this->getTenantModel()::checkCurrent()) {
			return redirect(route('auth.account.tenant.index'));
		}
		$tenant = $this->getTenantModel()::current();
		if( !(new Database())->schemaExists($tenant->getDatabaseName()) ){
			return redirect(route("auth.account.no.database"));
		}
		$tenant->makeCurrent();

		return $next($request);
	}
}
