<?php

namespace Bcampti\Larabase\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class LarabaseAllMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabase:all {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model and all resources.[ Model, Filtro, FormRequest, Controller, Manager and Blades ]. Ex.: php artisan larabase:all Locale/Pais';

    public function getStub(){}

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->createModel();
        $this->createFactory();
        $this->createMigration();
        $this->createTests();
        $this->createFiltro();
        $this->createRepository();
        $this->createFormRequest();
        $this->createController();
        $this->createViews();
        $this->createRoutes();
    }
    
    /**
     * Create a model.
     *
     * @return void
     */
    protected function createModel()
    {
        $name = $this->argument('name');
        
        $this->call('larabase:model', array_filter([
            'name'  => $name,
        ]));
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $modelName = Str::studly($this->argument('name'));

        $this->call('make:factory', [
            'name' => "{$modelName}Factory",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::snake(class_basename($this->argument('name')));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createTests()
    {
        $modelName = Str::studly($this->argument('name'));

        // create a Feature test for the Controller
        $this->call('larabase:test', [
            'name' => "{$modelName}ControllerTest",
            '--model' => $modelName,
        ]);

        // create a Unit test for the Model
        $this->call('larabase:test', [
            'name' => "{$modelName}Test",
            '--unit' => true,
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createFiltro()
    {
        $filtro = $this->argument('name');
        
        $this->call('larabase:filtro', array_filter([
            'name'  => "{$filtro}Filtro",
            '--model' => $filtro,
        ]));
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createRepository()
    {
        $name = $this->argument('name');
        
        $this->call('larabase:repository', array_filter([
            'name'  => "{$name}Manager",
            '--model' => $name
        ]));
    }

    /**
     * Create a form request for the model.
     *
     * @return void
     */
    protected function createFormRequest()
    {
        $modelName = $this->argument('name');
        
        $this->call('larabase:request', array_filter([
            'name'  => "{$modelName}Request",
            '--model' => $modelName,
        ]));
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $modelName = $this->argument('name');
        
        $this->call('larabase:controller', array_filter([
            'name'  => "{$modelName}Controller",
            '--model' => $modelName,
        ]));
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createViews()
    {
        $modelName = $this->argument('name');
        
        $this->call('larabase:view', array_filter([
            'name'  => 'listar',
            '--model' => $modelName,
        ]));

        $this->call('larabase:view', array_filter([
            'name'  => 'formulario',
            '--model' => $modelName,
        ]));
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createRoutes()
    {
        $name = $this->argument('name');
        
        $this->call('larabase:route', array_filter([
            'name'  => $name,
            '--model' => $name,
        ]));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    /* protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, policy, and resource controller for the model'],
            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['test', 't', InputOption::VALUE_NONE, 'Create tests for the model'],
            ['filtro', null, InputOption::VALUE_NONE, 'Create a filtro for the model'],
            ['repository', null, InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],
            ['request', 'R', InputOption::VALUE_NONE, 'Create new form request classes and use them in the resource controller'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['view', 'v', InputOption::VALUE_NONE, 'Create views, index and formulario for the model'],
            ['route', null, InputOption::VALUE_NONE, 'Create a file with routes for the model'],
        ];
    } */
}
