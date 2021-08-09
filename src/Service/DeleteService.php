<?php

namespace FunctionalCoding\Illuminate;

use FunctionalCoding\Illuminate\Feature\ModelFeatureService;
use FunctionalCoding\Service;

class DeleteService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [
            'result.model' => function ($model) {
                $model->delete();
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => function () {
                return null;
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
