<?php

namespace Bcampti\Larabase;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Bcampti\Larabase\Commands\LarabaseCommand;

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
            ->hasCommand(LarabaseCommand::class);
    }
}
