<?php

namespace Bcampti\Larabase\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Tenant;

class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    protected $with = ['user','auditable'];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'old_values'   => 'json',
        'new_values'   => 'json',
        // Note: Please do not add 'auditable_id' in here, as it will break non-integer PK models
    ];

    public function getConnectionName()
    {
        if( Tenant::checkCurrent() ){
            return config("multitenancy.tenant_database_connection_name");
        }else{
            return config("multitenancy.landlord_database_connection_name");
        }
    }

}
