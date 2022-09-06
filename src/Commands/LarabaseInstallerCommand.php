<?php

namespace Bcampti\Larabase\Commands;

use Bcampti\Larabase\Presets\Traits\AuditCommandTrait;
use Bcampti\Larabase\Presets\Traits\HandleFiles;
use Bcampti\Larabase\Presets\Traits\MultitenancyCommandTrait;
use Bcampti\Larabase\Presets\Traits\MigrationCommandTrait;
use Bcampti\Larabase\Presets\Traits\TranslateCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LarabaseInstallerCommand extends Command
{
    use AuditCommandTrait;
    use MultitenancyCommandTrait;
    use HandleFiles;
    use MigrationCommandTrait;
    use TranslateCommandTrait;
    
    public $signature = 'larabase:install';

    public $description = 'Instala a configuração inicial e de login para multi-tenancy';

    public function handle(): void
    {
        $this->publishAudit()
            ->publishMultitenancy()
            ->publishMigrations()
            ->publishTranslate();
        
        shell_exec("php artisan ui bootstrap --auth");

        $this->publishAppResources()
            ->publishConfigResources()
            ->publishRouteResources();

        
        $this->replaceWithMetronicTheme();

        $this->info('Installed Larabase package');
    }

    public function publishAppResources():self
    {
        $this->ensureDirectoryExists(app_path('View'));

        $files = [
            'app/Exceptions/Handler.php',
            'app/Http/Controllers/Auth/RegisterController.php',
            'app/Http/Controllers/Auth/LoginController.php',
            'app/Http/Kernel.php',
            'app/Models/User.php',
            'app/Providers/AppServiceProvider.php',
            'app/Providers/RouteServiceProvider.php',
            'app/View/Account/Status.php',
            'app/View/Model/Status.php',
        ];
        $this->publishFiles($files);

        return $this;
    }

    public function publishConfigResources():self
    {
        $files = [
            'config/app.php',
        ];
        $this->publishFiles($files);

        return $this;
    }

    public function publishRouteResources():self
    {
        /* Copia o conteudo de um arquivo para o outro
        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/../../stubs/routes/web.stub'),
            FILE_APPEND
        ); */

        $files = [
            'routes/web.php',
        ];
        $this->publishFiles($files);

        return $this;
    }

    protected function replaceWithMetronicTheme()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                'resolve-url-loader' => '^4.0.0',
                'bootstrap' => '~5.1.3',
            ] + $packages;
        });

        (new Filesystem)->ensureDirectoryExists(public_path('assets'));
        (new Filesystem)->ensureDirectoryExists(public_path('assets/metronic'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/public/assets/metronic', public_path('assets/metronic'));
        
        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/account'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth/passwords'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/errors'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts/partials'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/pagination'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/account', resource_path('views/account'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth/passwords', resource_path('views/auth/passwords'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/components', resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/components/account', resource_path('views/components/account'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/components/model', resource_path('views/components/model'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/errors', resource_path('views/errors'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/layouts/partials', resource_path('views/layouts/partials'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/pagination', resource_path('views/pagination'));

        copy(__DIR__ . '/../../resources/views/home.blade.php', resource_path('views/home.blade.php'));

        $this->components->info('Larabase instalado com sucesso.');
        $this->components->warn('Para finalizar execute "npm install && npm run dev" para fazer deploy dos assets.');
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
