<?php

namespace Bcampti\Larabase;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Bcampti\Larabase\Commands\LarabaseCommand;
use Bcampti\Larabase\Commands\LarabaseHelpCommand;
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
                LarabaseHelpCommand::class,
                LarabaseMakerCommand::class,
                LarabaseAllMakeCommand::class,
                LarabaseControllerMakeCommand::class,
                LarabaseFiltroMakeCommand::class,
                LarabaseModelMakeCommand::class,
                LarabaseRepositoryMakeCommand::class,
                LarabaseRequestMakeCommand::class,
                LarabaseRouteMakeCommand::class,
                LarabaseTestMakeCommand::class,
                LarabaseViewMakeCommand::class,
            ]);

            //->hasViewComponent('spatie', Alert::class)
            //->hasViewComposer('*', MyViewComposer::class)
            //->sharesDataWithAllViews('downloads', 3)
            //->hasTranslations()
            //->hasAssets()
            //->hasRoute('web')
    }
}
