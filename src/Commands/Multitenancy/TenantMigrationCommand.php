<?php

namespace Bcampti\Larabase\Commands\Multitenancy;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "migrate:tenant {--tenant=*} {--force}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Executa o comando de migrate no(s) tenant(s).";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function handle()
    {
        $artisanCommand = 'tenants:artisan "migrate --path=database/migrations/tenant --database=tenant"';
        if( $this->hasOption('force') ){
            $artisanCommand = 'tenants:artisan "migrate --path=database/migrations/tenant --database=tenant --force"';
        }
        $tenant = $this->option('tenant');
        if( !is_empty($tenant) ){
            $artisanCommand.=" --tenant=".$tenant[0];
        }

        Artisan::call($artisanCommand, [], $this->output);
    }
}
