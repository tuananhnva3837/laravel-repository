<?php

namespace AnhAiT\LaravelRepository\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    protected $type = 'Repository';

    protected $name = 'make:repository';

    protected $description = 'Create a new repository class';

    /**
     * Build the class with the given name.
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub   = parent::buildClass($name);
        $model  = $this->option('model');
        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Replace the model for the given stub.
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $model  = str_replace('/', '\\', $model);
        $namespaceModel = $this->laravel->getNamespace().$model;

        $stub   = (Str::startsWith($model, '\\'))
              ? str_replace('NamespacedDummyModel', trim($model, '\\'), $stub)
              : str_replace('NamespacedDummyModel', $namespaceModel, $stub);

        $stub   = str_replace(
            "use {$namespaceModel};\nuse {$namespaceModel};", "use {$namespaceModel};", $stub
        );
        $model  = class_basename(trim($model, '\\'));
        $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;
        return str_replace('DummyModel', $model, $stub);
    }

    protected function getStub()
    {
        return $this->option('model')
                    ? __DIR__ . '/Stubs/repository.stub'
                    : __DIR__ . '/Stubs/repository.plain.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repository';
    }

    /**
    * Get the console command options.
    * @return array
    */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the repository applies to']
        ];
    }
}
