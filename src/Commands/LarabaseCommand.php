<?php

namespace Bcampti\Larabase\Commands;

use Illuminate\Console\Command;

class LarabaseCommand extends Command
{
    public $signature = 'larabase';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
