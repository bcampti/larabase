<?php

namespace Bcampti\Larabase\Commands\Make;

use Illuminate\Routing\Console\ControllerMakeCommand as ConsoleControllerMakeCommand;
use Illuminate\Support\Str;

class LarabaseControllerMakeCommand extends ConsoleControllerMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larabase:controller {name}';

    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class. Ex.: php artisan larabase:controller Locale/PaisController --model=Locale/Pais';

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('parent')) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);

            $folderPath = $this->option('model');
            $folderPath = str_replace('/', '\\', $folderPath);
            // REPOSITORY / MANAGER
            $replace['{{ repositoryNamespace }}'] = "App\Repositories\\{$folderPath}Manager";
            // FORM REQUEST / VALIDATION
            $replace['{{ requestNamespace }}'] = "App\Http\Requests\\{$folderPath}Request";

            $modelClass = $this->parseModel($this->option('model'));

            $snake = Str::snake(class_basename($modelClass));
            $route = Str::replace("_",".",$snake);

            $replace['{{ snakeModelName }}'] = $snake;
            $replace['{{snakeModelName}}'] = $snake;
            $replace['{{ routeModelName }}'] = $route;
            $replace['{{routeModelName}}'] = $route;
        }

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

}
