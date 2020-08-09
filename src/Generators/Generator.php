<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Str;
use LaravelApiCrudGenerator\TwigExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Generator
{
    const TYPE_BASE_REPOSITORY = 'baseRepository';
    const TYPE_FORM_REQUEST = 'formRequest';
    const TYPE_PAGINATE_REQUEST = 'paginateRequest';
    const TYPE_MODEL = 'model';
    const TYPE_REPOSITORY = 'repository';
    const TYPE_SAVE_REQUEST = 'saveRequest';
    const TYPE_CREATE_ACTION = 'createAction';
    const TYPE_GET_ACTION = 'getAction';
    const TYPE_LIST_ACTION = 'listAction';
    const TYPE_UPDATE_ACTION = 'updateAction';
    const TYPE_DELETE_ACTION = 'deleteAction';
    const TYPE_ROUTES = 'routes';

    protected string $type;
    protected string $path;
    protected string $fileName;
    protected Environment $twig;
    protected ?Table $table;

    public function __construct(string $type, string $fileName, ?Table $table = null)
    {
        $this->table = $table;
        $this->type = $type;
        $this->fileName = $fileName;
        $this->path = self::getPath($type, $this->table->name ?? null);

        $loader = new FilesystemLoader(__DIR__ . '/../Templates');
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new TwigExtension());
    }
     
    public static function generate(?Table $table = null): bool
    {
        $class = static::class;
        $instance = $table ? new $class($table) : new $class();
        
        return $instance->handle();
    }

    public static function getPath(string $type, ?string $tableName = null): string
    {
        $tableName = Str::singularStudly($tableName);
        $pathPattern = config("crudGenerator.path.$type");

        return str_replace('{entity}', $tableName, $pathPattern);
    }

    protected function saveFile(array $data): bool
    {
        $fullFileName = $this->path . '/' .$this->fileName;

        if (file_exists($fullFileName)) {
            return false;
        }

        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }

        $fileContent = $this->twig->render($this->type . '.twig', $data);
        
        $fileWrited = file_put_contents($fullFileName, $fileContent);

        return $fileWrited !== false;
    }

    public abstract function handle(): bool;
}
