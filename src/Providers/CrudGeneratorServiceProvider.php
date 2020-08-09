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
        $this->app->bind(MigrationRepositoryInterface::class, DatabaseMigrationRepository::class);

        $this->publishes([
            __DIR__ . '/../resources/config/crudGenerator.php' => config_path('crudGenerator.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../resources/config/crudGenerator.php', 'crudGenerator');
    }

    public function register()
    {
        $this->commands('LaravelApiCrudGenerator\Commands\CrudGenerateCommand');
    }

    public function provides()
    {
        return [];
    }
}
