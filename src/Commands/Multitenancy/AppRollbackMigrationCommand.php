<?php

namespace Bcampti\Larabase\Console\Commands\Multitenancy;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppRollbackMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "migrate:rollbackApp";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Executa o comando de rollback no landloard. Apenas o ultimo migration";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function handle()
    {
        $artisanCommand = 'migrate:rollback --step=1 --path=database/migrations/landlord --database=landlord';
        
        Artisan::call($artisanCommand, [], $this->output);
    }
}
