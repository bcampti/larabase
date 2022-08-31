<?php

namespace Bcampti\Larabase\Presets\Traits;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

trait InstallCommand
{
    public function publishAuth()
    {
        $this->php_version = 'php';
        
        $this->requireComposerPackages('laravel/ui:^4.0');
        shell_exec("{$this->php_version} artisan ui bootstrap --auth");

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/../../../stubs/routes.stub'),
            FILE_APPEND
        );

        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/controllers', app_path('Http/Controllers/'));

        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/requests', app_path('Http/Requests/'));

        copy(__DIR__ . '/../../../stubs/ui/AppServiceProvider.php', app_path('Providers/AppServiceProvider.php'));
        copy(__DIR__ . '/../../../stubs/ui/vite.config.js', base_path('vite.config.js'));

        return $this->replaceWithCoreUITheme();
    }

    protected function replaceWithCoreUITheme()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                'resolve-url-loader' => '^4.0.0',
                'bootstrap' => '~5.1.3',
            ] + $packages;
        });

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth/passwords'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('sass'));

        /* (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/ui/metronic/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/ui/metronic/views/auth/passwords', resource_path('views/auth/passwords'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/ui/metronic/views/layouts', resource_path('views/layouts'));

        // Assets
        (new Filesystem)->ensureDirectoryExists(public_path('icons'));
        (new Filesystem)->ensureDirectoryExists(public_path('js'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/ui/metronic/icons', public_path('icons'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/ui/metronic/sass', resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../../stubs/ui/metronic/js', public_path('js'));

        copy(__DIR__ . '/../../../stubs/ui/metronic/views/home.blade.php', resource_path('views/home.blade.php'));
        copy(__DIR__ . '/../../../stubs/ui/metronic/views/about.blade.php', resource_path('views/about.blade.php'));

        // Demo table
        (new Filesystem)->ensureDirectoryExists(resource_path('views/users'));
        copy(__DIR__ . '/../../../stubs/ui/metronic/views/users/index.blade.php', resource_path('views/users/index.blade.php')); */

        $this->components->info('Laravel UI scaffolding replaced successfully.');
        $this->components->warn('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Installs the given Composer Packages into the application.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param mixed $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Update the "package.json" file.
     * Taken from https://github.com/laravel/breeze/blob/1.x/src/Console/InstallCommand.php
     *
     * @param callable $callback
     * @param bool $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
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
    }
}