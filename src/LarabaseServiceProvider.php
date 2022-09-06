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
            
            /* ->hasMigrations(
                'landlord/2014_10_12_000000_create_users_table',
                'landlord/2014_10_12_100000_create_password_resets_table',
                'landlord/2019_08_19_000000_create_failed_jobs_table',
                'landlord/2022_09_01_170342_create_account_tenants_table',
                'landlord/2022_09_01_171049_create_audits_table',
                'landlord/2022_09_01_172625_add_custom_field_to_users_table',
                'tenant/2022_09_01_000000_create_usuario_table',
                'tenant/2022_09_01_171049_create_organizacao_table',
                'tenant/2022_09_01_172625_add_custom_field_to_usuario_table',
                'tenant/2022_09_01_193049_create_audits_table',
            ) */
            //->hasViewComponent('spatie', Alert::class)
            //->hasViewComposer('*', MyViewComposer::class)
            //->sharesDataWithAllViews('downloads', 3)
            //->hasTranslations()
            //->hasAssets()
            //->hasRoute('web')
    }

    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->package->basePath('/../stubs/stubs') => base_path("stubs"),
            ], "{$this->package->shortName()}-stubs");
        }

        /* $this->loadViewsFrom(__DIR__.'/../resources/views', 'larabase');
        $this->registerRoutes();
        $this->loadViewComponentsAs('larabase', [
            StatusAccountEnum::class,
        ]); */
    }
    
    /* protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
    
    protected function routeConfiguration()
    {
        return [
            'prefix' => config('larabase.prefix'),
            'middleware' => config('larabase.middleware'),
        ];
    } */

}
