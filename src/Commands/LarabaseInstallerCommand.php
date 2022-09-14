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
    use HandleFiles;
    use MigrationCommandTrait;
    use MultitenancyCommandTrait;
    use TranslateCommandTrait;
    
    public $signature = 'larabase:install';

    public $description = 'Instala a configuração inicial e de login para multi-tenancy';

    public function handle(): void
    {
        $this->publishAudit();
        $this->publishMultitenancy();
        $this->publishMigrations();
        $this->publishTranslate();
        
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
        $this->ensureDirectoryExists(app_path('View/Account'));
        $this->ensureDirectoryExists(app_path('View/Model'));

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
        $this->updateNodePackages(function ($packages) {
            return [
                "dev" => "npm run development",
                "development" => "mix",
                "watch" => "mix watch",
                "watch-poll" => "mix watch -- --watch-options-poll=1000",
                "hot" => "mix watch --hot",
                "prod" => "npm run production",
                "production" => "mix --production"
            ];
        },'scripts');

        $this->updateNodePackages(function ($packages) {
            return [
                "@ckeditor/ckeditor5-alignment" => "^34.0.0",
                "@ckeditor/ckeditor5-build-balloon" => "^34.0.0",
                "@ckeditor/ckeditor5-build-balloon-block" => "^34.0.0",
                "@ckeditor/ckeditor5-build-classic" => "^34.0.0",
                "@ckeditor/ckeditor5-build-decoupled-document" => "^34.0.0",
                "@ckeditor/ckeditor5-build-inline" => "^34.0.0",
                "@fortawesome/fontawesome-free" => "^6.1.1",
                "@popperjs/core" => "2.11.5",
                "@shopify/draggable" => "^1.0.0-beta.12",
                "@yaireo/tagify" => "^4.9.2",
                "acorn" => "^8.0.4",
                "apexcharts" => "^3.33.1",
                "autosize" => "^5.0.1",
                "axios" => "^0.21.1",
                "bootstrap" => "5.2.0",
                "bootstrap-cookie-alert" => "^1.2.1",
                "bootstrap-daterangepicker" => "^3.1.0",
                "bootstrap-icons" => "^1.5.0",
                "bootstrap-maxlength" => "^1.10.1",
                "bootstrap-multiselectsplitter" => "^1.0.4",
                "chalk" => "^4.1.0",
                "chart.js" => "^3.6.0",
                "clipboard" => "^2.0.8",
                "countup.js" => "^2.0.7",
                "cropperjs" => "^1.5.12",
                "datatables.net" => "^1.12.1",
                "datatables.net-bs5" => "^1.12.1",
                "datatables.net-buttons" => "^2.2.3",
                "datatables.net-buttons-bs5" => "^2.2.3",
                "datatables.net-colreorder" => "^1.5.6",
                "datatables.net-colreorder-bs5" => "^1.5.6",
                "datatables.net-datetime" => "^1.1.2",
                "datatables.net-fixedcolumns" => "^4.1.0",
                "datatables.net-fixedcolumns-bs5" => "^4.1.0",
                "datatables.net-fixedheader" => "^3.2.3",
                "datatables.net-fixedheader-bs5" => "^3.2.3",
                "datatables.net-plugins" => "^1.11.5",
                "datatables.net-responsive" => "^2.3.0",
                "datatables.net-responsive-bs5" => "^2.3.0",
                "datatables.net-rowgroup" => "^1.2.0",
                "datatables.net-rowgroup-bs5" => "^1.2.0",
                "datatables.net-rowreorder" => "^1.2.8",
                "datatables.net-rowreorder-bs5" => "^1.2.8",
                "datatables.net-scroller" => "^2.0.6",
                "datatables.net-scroller-bs5" => "^2.0.6",
                "datatables.net-select" => "^1.4.0",
                "datatables.net-select-bs5" => "^1.4.0",
                "dropzone" => "^5.9.2",
                "es6-promise" => "^4.2.8",
                "es6-promise-polyfill" => "^1.2.0",
                "es6-shim" => "^0.35.5",
                "esri-leaflet" => "^3.0.2",
                "esri-leaflet-geocoder" => "^3.0.0",
                "flatpickr" => "^4.6.9",
                "flot" => "^4.2.2",
                "fslightbox" => "^3.3.0-2",
                "fullcalendar" => "^5.8.0",
                "handlebars" => "^4.7.7",
                "inputmask" => "^5.0.6",
                "jkanban" => "^1.3.1",
                "jquery" => "3.6.0",
                "jquery.repeater" => "^1.2.1",
                "jstree" => "^3.3.11",
                "jszip" => "^3.6.0",
                "leaflet" => "^1.7.1",
                "line-awesome" => "^1.3.0",
                "moment" => "^2.29.1",
                "nouislider" => "^15.2.0",
                "npm" => "^7.19.1",
                "pdfmake" => "^0.2.0",
                "prism-themes" => "^1.7.0",
                "prismjs" => "^1.24.1",
                "quill" => "^1.3.7",
                "select2" => "^4.1.0-rc.0",
                "smooth-scroll" => "^16.1.3",
                "sweetalert2" => "^11.0.18",
                "tiny-slider" => "^2.9.3",
                "tinymce" => "^5.8.2",
                "toastr" => "^2.1.4",
                "typed.js" => "^2.0.12",
                "vis-timeline" => "^7.4.9",
                "wnumb" => "^1.2.0"
            ] + $packages;
        },'dependencies');

        $this->updateNodePackages(function ($packages) {
            return [
                "alpinejs" => "^3.7.1",
                "autoprefixer" => "^10.4.2",
                "axios" => "^0.24.0",
                "del" => "^6.0.0",
                "laravel-mix" => "^6.0.39",
                "laravel-mix-purgecss" => "^6.0.0",
                "lodash" => "^4.17.19",
                "postcss" => "^8.4.5",
                "postcss-import" => "^14.0.2",
                "replace-in-file-webpack-plugin" => "^1.0.6",
                "resolve-url-loader" => "^4.0.0",
                "rtlcss" => "^3.5.0",
                "sass" => "^1.47.0",
                "sass-loader" => "^12.4.0",
                "webpack-rtl-plugin" => "^2.0.0"
            ] + $packages;
        },'devDependencies');

        copy(__DIR__ . '/../../stubs/webpack/webpack.mix.js', base_path('webpack.mix.js'));

        (new Filesystem)->ensureDirectoryExists(public_path('assets'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/assets'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/assets', resource_path('assets'));
        
        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/account'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/errors'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/organizacao'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/pagination'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/account', resource_path('views/account'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/components', resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/errors', resource_path('views/errors'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../resources/views/organizacao', resource_path('views/organizacao'));
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
     * @param  string $configurationKey, ['devDependencies', 'dependencies', 'scripts']
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $configurationKey = 'devDependencies')
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        //$configurationKey = $dev ? 'devDependencies' : 'dependencies';

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
