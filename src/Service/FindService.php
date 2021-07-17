<?php

namespace FunctionalCoding\Illuminate;

use FunctionalCoding\Service;
use FunctionalCoding\Illuminate\Feature\ExpandsFeatureService;
use FunctionalCoding\Illuminate\Feature\FieldsFeatureService;
use FunctionalCoding\Illuminate\Feature\ModelFeatureService;

class FindService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbackLists()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => function ($model) {

                return $model;
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
        return [
            ExpandsFeatureService::class,
            FieldsFeatureService::class,
            ModelFeatureService::class,
        ];
    }
}
