<?php

namespace Bcampti\Larabase\Commands\Multitenancy;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "migrate:app {--force}";

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
        $artisanCommand = 'migrate --database=landlord';
        if( $this->hasOption('force') ){
            $artisanCommand = 'migrate --database=landlord --force';
        }

        Artisan::call($artisanCommand, [], $this->output);

        $artisanCommand = 'migrate --path=database/migrations/landlord --database=landlord';
        if( $this->hasOption('force') ){
            $artisanCommand = 'migrate --path=database/migrations/landlord --database=landlord --force';
        }
        Artisan::call($artisanCommand, [], $this->output);
    }
}
