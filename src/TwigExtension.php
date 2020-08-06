<?php

namespace LaravelApiCrudGenerator;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('singularStudly', '\LaravelApiCrudGenerator\Str::singularStudly'),
            new TwigFilter('ucfirst', 'ucfirst'),
        ];
    }
}