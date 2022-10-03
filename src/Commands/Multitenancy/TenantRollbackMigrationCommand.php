<?php

namespace Bcampti\Larabase\Commands\Multitenancy;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantRollbackMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "migrate:rollbackTenant {--tenant=*}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Executa o comando de rollback no(s) tenant(s). Apenas o ultimo migration";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function handle()
    {
        $artisanCommand = 'tenants:artisan "migrate:rollback --step=1 --path=database/migrations/tenant --database=tenant"';
        
        $tenant = $this->option('tenant');
        if( !is_empty($tenant) ){
            $artisanCommand.=" --tenant=".$tenant[0];
        }

        Artisan::call($artisanCommand, [], $this->output);
    }
}
