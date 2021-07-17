<?php

namespace FunctionalCoding\Illuminate\Feature;

use FunctionalCoding\Service;

class QueryFeatureService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'model_class' => function () {

                throw new \Exception;
            },

            'query' => function ($modelClass) {

                return $modelClass::query();
            },
        ];
    }

    public static function getArrPromiseLists()
    {
        return [];
    }

    public static function getArrRuleLists()
    {
        return [];
    }

    public static function getArrTraits()
    {
        return [];
    }
}
