<?php

namespace Bcampti\Larabase\Commands;

use Bcampti\Larabase\Presets\Traits\AuditTrait;
use Bcampti\Larabase\Presets\Traits\ExceptionsTrait;
use Bcampti\Larabase\Presets\Traits\MultitenancyTrait;
use Bcampti\Larabase\Presets\Traits\StubTrait;
use Illuminate\Console\Command;

class LarabaseInstallerCommand extends Command
{
    use ExceptionsTrait;
    use AuditTrait;
    use MultitenancyTrait;
    use StubTrait;
    
    public $signature = 'larabase:install';

    public $description = 'Instala a configuração inicial e de login para multi-tenancy';

    public function handle(): void
    {
        $this->publishAudit()
            ->publishMultitenancy();
        
        $this->exportExceptions();

        $this->info('Installed Larabase package');
    }

}
