<?php
namespace Bcampti\Larabase\Multitenancy\TenantFinder;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class LarabaseTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    public function findForRequest(Request $request):?Tenant
    {
        //$host = $request->getHost();
        //return $this->getTenantModel()::whereDomain($host)->first();
        if( !auth()->hasUser() ){
            return null;
        }
        return auth()->user()->account;
    }
}