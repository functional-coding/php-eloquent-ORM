<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service;

use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\ExpandsFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\FieldsFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\ModelFeatureService;
use SimplifyServiceLayer\Service;

class FindService extends Service
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
            'result' => function ($model) {
                return $model;
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
        return [
            ExpandsFeatureService::class,
            FieldsFeatureService::class,
            ModelFeatureService::class,
        ];
    }
}
