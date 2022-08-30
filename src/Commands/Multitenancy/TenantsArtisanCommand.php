<?php

namespace Bcampti\Larabase\Console\Commands\Multitenancy;

use Bcampti\Larabase\Utils\Database\Database;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Commands\Concerns\TenantAware;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;

class TenantsArtisanCommand extends Command
{
    use UsesTenantModel, UsesMultitenancyConfig, TenantAware;

    protected $signature = 'multitenancy:artisan {artisanCommand} {--tenant=*}';

    public function handle()
    {
        if (! $artisanCommand = $this->argument('artisanCommand')) {
            $artisanCommand = $this->ask('Which artisan command do you want to run for all tenants?');
        }

        $tenant = Tenant::current();

        $database = new Database();
        if( $database->schemaExists($tenant->schema_name) ){
            $this->line('');
            $this->info("Executando comando na companhia (id: {$tenant->getKey()}) `{$tenant->empresa}`...");
            $this->line("---------------------------------------------------------");

            Artisan::call($artisanCommand, [], $this->output);
        }
        /* else{
            $this->warn('');
            $this->warn("Companhia (id: {$tenant->getKey()}) `{$tenant->empresa}` não possui base");
            $this->line("---------------------------------------------------------");

        } */
    }
}
