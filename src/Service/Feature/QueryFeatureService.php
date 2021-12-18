<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Feature;

use FunctionalCoding\Service;

class QueryFeatureService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'model_class' => function () {
                throw new \Exception();
            },

            'query' => function ($modelClass) {
                return $modelClass::query();
            },
        ];
    }

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [];
    }

    public static function getTraits()
    {
        return [];
    }
}
