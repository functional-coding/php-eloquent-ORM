<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ModelFeatureService;
use FunctionalCoding\Service;

class DeleteService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'result.model' => function ($model) {
                $model->delete();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'result' => function () {
                return null;
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
