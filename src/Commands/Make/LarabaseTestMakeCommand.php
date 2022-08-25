<?php

namespace Bcampti\Larabase\Commands\Make;

use Illuminate\Foundation\Console\TestMakeCommand as ConsoleTestMakeCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class LarabaseTestMakeCommand extends ConsoleTestMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larabase:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 
    'Create a new controller class. 
                Ex.: php artisan larabase:test Locale/PaisControllerTest --model=Locale/Pais
                     php artisan larabase:test Locale/PaisTest --model=Locale/Pais --unit';

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

        $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);

        $replace = [];

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );

    }

    /**
     * Build the model replacement values.
     *
     * @param  array  $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        $snake = Str::snake(class_basename($modelClass));
        $route = Str::replace("_",".",$snake);

        $formStore = class_basename($modelClass)."StoreRequest";
        $formUpdate = class_basename($modelClass)."UpdateRequest";

        $namespacedFormStore = "App\Http\Requests\Locale\\".$formStore;
        $namespacedFormUpdate = "App\Http\Requests\Locale\\".$formUpdate;

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
            '{{ snakeModelName }}' => $snake,
            '{{snakeModelName}}' => $snake,
            '{{ routeModelName }}' => $route,
            '{{routeModelName}}' => $route,
            '{{ formStore }}' => $formStore,
            '{{ formUpdate }}' => $formUpdate,
            '{{ namespacedFormStore }}' => $namespacedFormStore,
            '{{ namespacedFormUpdate }}' => $namespacedFormUpdate,
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }
        $model = ltrim($model, '\\/');
        $model = str_replace('/', '\\', $model);
        return 'App\\Models\\'.$model;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['unit', 'u', InputOption::VALUE_NONE, 'Create a unit test.'],
            ['pest', 'p', InputOption::VALUE_NONE, 'Create a Pest test.'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource repository for the given model.'],
        ];
    }

}