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

        $this->info('Installed Larabase package');
    }

}
