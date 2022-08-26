<?php

namespace Bcampti\Larabase\Commands;

use Illuminate\Console\Command;

class LarabaseCommand extends Command
{
    public $signature = 'larabase:install';

    public $description = 'Instala a configuração inicial e de login para multi-tenancy';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
