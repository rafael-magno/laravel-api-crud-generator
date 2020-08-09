<?php

namespace LaravelApiCrudGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use LaravelApiCrudGenerator\Entities\Field;
use LaravelApiCrudGenerator\Entities\Relation;
use LaravelApiCrudGenerator\Entities\Table;
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

    protected function __construct(TableRepository $tableRepository)
    {
        parent::__construct();

        $this->tableRepository = $tableRepository;

        Config::set('DB_CONNECTION', 'sqlite');
        Config::set('DB_DATABASE', ':memory:');

        Artisan::call('migrate');
    }

    public function handle()
    {
        $tables = $this->tableRepository->getEntities();

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
        
        //$this->info("CRUD created successfully.\n\n Remove the namespace route.\n" . $messageAddRoutes);
    }

    private function getTables(): array
    {
        return [
            new Table(
                'users',
                [],
                [
                    new Field('name', 'varchar', true, false),
                    new Field('email', 'varchar', true, true),
                    new Field('email_verified_at', 'datetime', false, false),
                    new Field('password', 'varchar', true, false),
                    new Field('remember_token', 'varchar', false, false),
                ]
            ),
            new Table(
                'students',
                [
                    new Relation('shift', 'belongsTo', 'shifts'),
                    new Relation('subjects', 'belongsToMany', 'subjects'),
                ],
                [
                    new Field('name', 'varchar', true, false),
                    new Field('shift_id', 'integer', true, false),
                ]
            ),
            new Table(
                'shifts',
                [
                    new Relation('students', 'hasMany', 'students'),
                ],
                [
                    new Field('name', 'varchar', true, true),
                ]
            ),
            new Table(
                'subjects',
                [
                    new Relation('students', 'belongsToMany', 'students'),
                ],
                [
                    new Field('name', 'varchar', true, true),
                ]
            ),
        ];
    }
}
