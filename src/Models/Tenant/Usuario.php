<?php

namespace Bcampti\Larabase\Models\Tenant;

use Bcampti\Larabase\Models\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Usuario extends Model
{
    use UsesTenantConnection;
    
    protected $table = "usuario";
}