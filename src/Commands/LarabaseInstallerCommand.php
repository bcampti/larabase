<?php

namespace Bcampti\Larabase\Commands;

use Bcampti\Larabase\Presets\Traits\AuditTrait;
use Bcampti\Larabase\Presets\Traits\HandleFiles;
use Bcampti\Larabase\Presets\Traits\MultitenancyTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LarabaseInstallerCommand extends Command
{
    use AuditTrait;
    use MultitenancyTrait;
    use HandleFiles;
    
    public $signature = 'larabase:install';

    public $description = 'Instala a configuração inicial e de login para multi-tenancy';

    public function handle(): void
    {
        $this->publishAudit()
            ->publishMultitenancy();
        
        $this->ensureDirectoryExists(app_path('Exceptions'));
        $this->ensureDirectoryExists(app_path('Http'));

        $scopes = [
            'app/Exceptions/Handler.php',
            'app/Http/Kernel.php',
            'app/Providers/AppServiceProvider.php',
            'config/app.php',
        ];
        $this->publishFiles($scopes);

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/../../../stubs/routes/web.stub'),
            FILE_APPEND
        );

        $this->info('Installed Larabase package');
    }

    /* protected function replaceWithCoreUITheme()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@coreui/coreui' => '^4.0.2',
                'resolve-url-loader' => '^4.0.0',
                'bootstrap' => '~5.1.3',
            ] + $packages;
        });

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth/passwords'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/ui/coreui/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/ui/coreui/views/auth/passwords', resource_path('views/auth/passwords'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/ui/coreui/views/layouts', resource_path('views/layouts'));

        // Assets
        (new Filesystem)->ensureDirectoryExists(public_path('icons'));
        (new Filesystem)->ensureDirectoryExists(public_path('js'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/ui/coreui/icons', public_path('icons'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/ui/coreui/sass', resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/stubs/ui/coreui/js', public_path('js'));

        copy(__DIR__ . '/../../resources/stubs/ui/coreui/views/home.blade.php', resource_path('views/home.blade.php'));
        copy(__DIR__ . '/../../resources/stubs/ui/coreui/views/about.blade.php', resource_path('views/about.blade.php'));

        // Demo table
        (new Filesystem)->ensureDirectoryExists(resource_path('views/users'));
        copy(__DIR__ . '/../../resources/stubs/ui/coreui/views/users/index.blade.php', resource_path('views/users/index.blade.php'));

        $this->components->info('Laravel UI scaffolding replaced successfully.');
        $this->components->warn('Please execute the "npm install && npm run dev" command to build your assets.');
    } */

    /**
     * Update the "package.json" file.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param callable $callback
     * @param bool $dev
     * @return void
     */
    /* protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    } */
}
