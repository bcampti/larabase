<?php

namespace Bcampti\Larabase\Commands;

use Bcampti\Larabase\Presets\Traits\AuditCommandTrait;
use Bcampti\Larabase\Presets\Traits\HandleFiles;
use Bcampti\Larabase\Presets\Traits\MultitenancyCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LarabaseInstallerCommand extends Command
{
    use AuditCommandTrait;
    use MultitenancyCommandTrait;
    use HandleFiles;
    
    public $signature = 'larabase:install';

    public $description = 'Instala a configuração inicial e de login para multi-tenancy';

    public function handle(): void
    {
        $this->publishAudit()
            ->publishMultitenancy()
            ->publishMigrations();
        
        shell_exec("php artisan ui bootstrap --auth");

        $this->ensureDirectoryExists(app_path('Exceptions'));
        $this->ensureDirectoryExists(app_path('Http'));

        $scopes = [
            'app/Exceptions/Handler.php',
            'app/Http/Kernel.php',
            'app/Models/User.php',
            'config/app.php',
        ];
        $this->publishFiles($scopes);

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/../../stubs/routes/web.stub'),
            FILE_APPEND
        );

        $this->replaceWithMetronicTheme();

        $this->info('Installed Larabase package');
    }

    protected function replaceWithMetronicTheme()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                //'@coreui/coreui' => '^4.0.2',
                'resolve-url-loader' => '^4.0.0',
                'bootstrap' => '~5.1.3',
            ] + $packages;
        });

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/account'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth/passwords'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/errors'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts/partials'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/pagination'));
        //(new Filesystem)->ensureDirectoryExists(resource_path('sass'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/account', resource_path('views/account'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth/passwords', resource_path('views/auth/passwords'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/errors', resource_path('views/errors'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/layouts/partials', resource_path('views/layouts/partials'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/pagination', resource_path('views/pagination'));

        (new Filesystem)->ensureDirectoryExists(public_path('assets'));
        (new Filesystem)->ensureDirectoryExists(public_path('assets/metronic'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/public/assets/metronic', public_path('assets/metronic'));


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

    public function publishMigrations()
    {
        (new Filesystem)->ensureDirectoryExists(database_path('factories'));
        (new Filesystem)->ensureDirectoryExists(database_path('migrations'));
        (new Filesystem)->ensureDirectoryExists(database_path('migrations/landlord'));
        (new Filesystem)->ensureDirectoryExists(database_path('migrations/tenant'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../database/migrations/landlord', public_path('database/migrations/landlord'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../database/migrations/tenant', public_path('database/migrations/tenant'));

        /* $this->publishFiles([
            'database/migrations/landlord/2014_10_12_000000_create_users_table.php',
            'database/migrations/landlord/2014_10_12_100000_create_password_resets_table.php',
            'database/migrations/landlord/2019_08_19_000000_create_failed_jobs_table.php',
            'database/migrations/landlord/2022_09_01_170342_create_account_tenants_table.php',
            'database/migrations/landlord/2022_09_01_171049_create_audits_table.php',
            'database/migrations/landlord/2022_09_01_172625_add_custom_field_to_users_table.php',
            
            'database/migrations/tenant/2022_09_01_000000_create_usuario_table.php',
            'database/migrations/tenant/2022_09_01_171049_create_organizacao_table.php',
            'database/migrations/tenant/2022_09_01_172625_add_custom_field_to_usuario_table.php',
            'database/migrations/tenant/2022_09_01_193049_create_audits_table.php'
        ]); */
    }
}
