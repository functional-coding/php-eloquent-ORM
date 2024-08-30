<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service;

use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\ModelFeatureService;
use SimplifyServiceLayer\Service;

class SoftDeleteService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'result#model' => function ($model) {
                $model->deleted_at = (new \DateTime())->format('Y-m-d H:i:s');
                $model->save();
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
