<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ModelFeatureService;
use FunctionalCoding\Service;

class UpdatingService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'result.model' => function ($model) {
                $model->save();
            },
        ];
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
            ModelFeatureService::class,
        ];
    }
}
