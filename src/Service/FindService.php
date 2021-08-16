<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ExpandsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\FieldsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\ModelFeatureService;
use FunctionalCoding\Service;

class FindService extends Service
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
