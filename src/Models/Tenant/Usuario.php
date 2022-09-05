<?php

namespace Bcampti\Larabase\Models\Tenant;

use Bcampti\Larabase\Models\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;

class Usuario extends Model
{
    use UsesTenantModel;
    
    protected $table = "usuario";
}