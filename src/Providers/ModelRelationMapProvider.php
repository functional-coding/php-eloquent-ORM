<?php

namespace FunctionalCoding\Illuminate\Providers;

use ArrayIterator;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class ModelRelationMapProvider extends ServiceProvider
{
    public function register()
    {
        $path = Container::getInstance()->path('Models');
        $dir = new RecursiveDirectoryIterator($path);
        $list = new RecursiveIteratorIterator($dir);
        $files = new RegexIterator($list, '/.+\.php$/');
        $types = [];

        foreach ($files as $file) {
            require_once $file->getPathname();
        }

        $classes = new RegexIterator(new ArrayIterator(get_declared_classes()), '/App\\\Models/');

        foreach ($classes as $class) {
            $segs = explode('\\', $class);
            $key = Str::snake(array_pop($segs));

            $types[$key] = $class;
        }

        Relation::morphMap($types);
    }
}
