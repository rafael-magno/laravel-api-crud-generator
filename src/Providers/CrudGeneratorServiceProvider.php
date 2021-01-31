<?php

namespace LaravelApiCrudGenerator\Providers;

use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CrudGeneratorServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../resources/config/crudGenerator.php' => config_path('crudGenerator.php')
        ], 'crud-generator');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/crudGenerator.php', 'crud-generator');

        $this->commands('LaravelApiCrudGenerator\Commands\CrudGenerateCommand');
    }

    public function provides()
    {
        return [];
    }
}
