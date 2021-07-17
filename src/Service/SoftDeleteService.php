<?php

namespace FunctionalCoding\Illuminate;

use FunctionalCoding\Service;
use FunctionalCoding\Illuminate\Feature\ModelFeatureService;

class SoftDeleteService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [
            'result.model' => function ($model) {

                $model->deleted_at = (new \DateTime)->format('Y-m-d H:i:s');
                $model->save();
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
