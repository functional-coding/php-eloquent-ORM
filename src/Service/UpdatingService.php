<?php

namespace FunctionalCoding\Illuminate;

use FunctionalCoding\Illuminate\Feature\ModelFeatureService;
use FunctionalCoding\Service;

class UpdatingService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [
            'result.model' => function ($model) {
                $model->save();
            },
        ];
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
            ModelFeatureService::class,
        ];
    }
}
