<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Str;
use LaravelApiCrudGenerator\TwigExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Generator
{
    const TYPE_MODEL = 'Model';

    protected Table $table;
    protected string $fileName;
    protected Environment $twig;

    public function __construct(Table $table, string $type)
    {
        $this->table = $table;
        $this->type = $type;
        $this->fileName = $this->getFileName($type, $this->table->name);

        $loader = new FilesystemLoader(__DIR__ . '/../Templates');
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new TwigExtension());
    }
     
    public static function generate(Table $table): bool
    {
        $class = static::class;
        $instance = new $class($table);
        
        return $instance->handle();
    }

    protected function getFileName(string $type, string $tableName): string
    {
        $tableName = Str::singularStudly($tableName);
        $fileNamePattern = 'outputTest/{tableName}/' . $type . '/{tableName}.php';

        return str_replace('{tableName}', $tableName, $fileNamePattern);
    }

    protected function saveFile(array $data): bool
    {
        if (file_exists($this->fileName)) {
            return false;
        }

        $dir = dirname($this->fileName);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fileContent = $this->twig->render($this->type . '.twig', $data);
        
        $fileWrited = file_put_contents($this->fileName, $fileContent);

        return $fileWrited !== false;
    }

    public abstract function handle(): bool;
}
