<?php

namespace LaravelApiCrudGenerator\Utils;

use Illuminate\Support\Str as SupportStr;

class Str extends SupportStr
{
    public static function singularStudly($stringSnakeCase)
    {
        $parts = explode('_', $stringSnakeCase);
        $lastWord = array_pop($parts);
        $stringSnakeCaseSingular = implode('_', $parts) . '_' . self::singular($lastWord);

        return self::studly($stringSnakeCaseSingular);
    }

    public static function singularKebab($stringSnakeCase)
    {
        return self::kebab(
            self::singularStudly($stringSnakeCase)
        );
    }

    public static function singularCamel($stringSnakeCase)
    {
        return self::camel(
            self::singularStudly($stringSnakeCase)
        );
    }

    public static function pathToNamespace($path)
    {
        $parts = explode('/', $path);
        $parts = array_map(fn($part) => ucfirst($part), $parts);

        return implode('\\', $parts);
    }
}
