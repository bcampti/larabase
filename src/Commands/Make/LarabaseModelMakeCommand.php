<?php

namespace Bcampti\Larabase\Commands\Make;

use Bcampti\Larabase\Commands\Traits\Settings;
use Illuminate\Foundation\Console\ModelMakeCommand as ConsoleModelMakeCommand;
use Illuminate\Support\Str;

class LarabaseModelMakeCommand extends ConsoleModelMakeCommand
{
    use Settings;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larabase:model';
    
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
                    ->replaceTable($stub, $name)
                    ->replaceClass($stub, $name);
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceTable(&$stub, $name)
    {
        $table = $this->getTableName($this->argument('name'));

        $stub = str_replace('{{ table }}', $table, $stub);

        return $this;
    }
}
