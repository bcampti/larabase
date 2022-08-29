<?php

namespace Bcampti\Larabase\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LarabaseMakerCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabase:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria todos os commandos artisan para um model especifico';

    public function getStub(){}
    
    public function handle()
    {
        $model = $this->argument('name');

        $commands = new Collection();
        //$commands->add("php artisan larabase:all {$model}");

        $commands->add("php artisan larabase:model {$model}");

        $commands->add("php artisan make:factory {$model}Factory  --model={$model}");

        $table = Str::snake(class_basename($model));
        $commands->add("php artisan make:migration create_{$table}_table --create={$table}");

        $commands->add("php artisan larabase:filtro {$model}Filtro --model={$model}");
        
        $commands->add("php artisan larabase:repository {$model}Manager --model={$model}");

        $commands->add("php artisan larabase:route {$model} --model={$model}");
        
        $commands->add("php artisan larabase:controller {$model}Controller --model={$model}");

        $commands->add("php artisan larabase:view listar --model={$model}");
        $commands->add("php artisan larabase:view formulario --model={$model}");

        $commands->add("php artisan larabase:request {$model}Request --model={$model}");

        $commands->add("php artisan larabase:test {$model}ControllerTest --model={$model}");
        $commands->add("php artisan larabase:test {$model}Test --model={$model} --unit");

        $this->printCommands($commands);
    }

    public function printCommands($commands)
    {
        foreach( $commands as $command )
        {
            $this->info($command);
        }
    }
}