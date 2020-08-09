<?php

namespace LaravelApiCrudGenerator\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('singularStudly', '\LaravelApiCrudGenerator\Str::singularStudly'),
            new TwigFilter('singularKebab', '\LaravelApiCrudGenerator\Str::singularKebab'),
            new TwigFilter('studly', '\LaravelApiCrudGenerator\Str::studly'),
            new TwigFilter('ucfirst', 'ucfirst'),
        ];
    }
}