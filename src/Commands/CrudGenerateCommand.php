<?php

namespace LaravelApiCrudGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use LaravelApiCrudGenerator\Generators\BaseRepositoryGenerator;
use LaravelApiCrudGenerator\Generators\CreateActionGenerator;
use LaravelApiCrudGenerator\Generators\DeleteActionGenerator;
use LaravelApiCrudGenerator\Generators\FormRequestGenerator;
use LaravelApiCrudGenerator\Generators\GetActionGenerator;
use LaravelApiCrudGenerator\Generators\ListActionGenerator;
use LaravelApiCrudGenerator\Generators\ModelGenerator;
use LaravelApiCrudGenerator\Generators\PaginateRequestGenerator;
use LaravelApiCrudGenerator\Generators\RepositoryGenerator;
use LaravelApiCrudGenerator\Generators\RoutesGenerator;
use LaravelApiCrudGenerator\Generators\SaveRequestGenerator;
use LaravelApiCrudGenerator\Generators\UpdateActionGenerator;
use LaravelApiCrudGenerator\Repositories\TableRepository;

class CrudGenerateCommand extends Command
{
    protected $name = 'make:crud';
    protected $description = 'Generate API CRUD.';
    protected $tableRepository;

    public function __construct(TableRepository $tableRepository)
    {
        parent::__construct();

        $this->tableRepository = $tableRepository;

    }
    
    public function handle()
    {
        $default = config('database.default');
        $database = config('database.connections.sqlite.database');
        $this->configDatabase('sqlite', ':memory:');
        Artisan::call('migrate');
        
        $tables = $this->tableRepository->getEntities();
        
        $this->configDatabase($default, $database);

        FormRequestGenerator::generate();
        PaginateRequestGenerator::generate();
        BaseRepositoryGenerator::generate();

        $messageAddRoutes = "Add the following routes: \n\n";

        foreach ($tables as $table) {
            ModelGenerator::generate($table);
            RepositoryGenerator::generate($table);
            SaveRequestGenerator::generate($table);
            CreateActionGenerator::generate($table);
            GetActionGenerator::generate($table);
            ListActionGenerator::generate($table);
            UpdateActionGenerator::generate($table);
            DeleteActionGenerator::generate($table);
            RoutesGenerator::generate($table);

            $pathRoutes = RoutesGenerator::getPath(RoutesGenerator::TYPE_ROUTES, $table->name);
            $messageAddRoutes .= "Route::group([], base_path('$pathRoutes/routes.php'));\n";
        }

        $this->info("CRUD created successfully.\n\n Remove the namespace route.\n" . $messageAddRoutes);
    }

    private function configDatabase(string $default, string $database): void
    {
        Config::set('database.connections.sqlite.database', $database);
        Config::set('database.default', $default);
        Config::clearResolvedInstances();
    }
}
