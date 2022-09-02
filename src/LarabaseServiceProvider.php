<?php

namespace Bcampti\Larabase;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Bcampti\Larabase\Commands\LarabaseHelpCommand;
use Bcampti\Larabase\Commands\LarabaseInstallerCommand;
use Bcampti\Larabase\Commands\LarabaseMakerCommand;
use Bcampti\Larabase\Commands\Make\LarabaseAllMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseControllerMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseFiltroMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseModelMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseRepositoryMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseRequestMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseRouteMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseTestMakeCommand;
use Bcampti\Larabase\Commands\Make\LarabaseViewMakeCommand;
use Bcampti\Larabase\Commands\Multitenancy\AppMigrationCommand;
use Bcampti\Larabase\Commands\Multitenancy\AppRollbackMigrationCommand;
use Bcampti\Larabase\Commands\Multitenancy\TenantMigrationCommand;
use Bcampti\Larabase\Commands\Multitenancy\TenantRollbackMigrationCommand;

class LarabaseServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('larabase')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_larabase_table')
            ->hasCommands([
                LarabaseInstallerCommand::class,
                LarabaseHelpCommand::class,
                LarabaseMakerCommand::class,
                LarabaseModelMakeCommand::class,
                LarabaseFiltroMakeCommand::class,
                LarabaseRepositoryMakeCommand::class,
                LarabaseRouteMakeCommand::class,
                LarabaseControllerMakeCommand::class,
                LarabaseRequestMakeCommand::class,
                LarabaseViewMakeCommand::class,
                LarabaseTestMakeCommand::class,
                LarabaseAllMakeCommand::class,

                AppMigrationCommand::class,
                AppRollbackMigrationCommand::class,
                TenantMigrationCommand::class,
                TenantRollbackMigrationCommand::class,
            ]);

            //->hasViewComponent('spatie', Alert::class)
            //->hasViewComposer('*', MyViewComposer::class)
            //->sharesDataWithAllViews('downloads', 3)
            //->hasTranslations()
            //->hasAssets()
            //->hasRoute('web')

            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->package->basePath('/../stubs/stubs') => base_path("stubs"),
            ], "{$this->package->shortName()}-stubs");
        }
    }

}
