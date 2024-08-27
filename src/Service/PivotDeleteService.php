<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ModelFeatureService;
use FunctionalCoding\Service;

class PivotDeleteService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'model#related' => function ($model, $relatedMethod, $related = '') {
                $relObj = $model->{$relatedMethod}();

                if ($related) {
                    $relObj->wherePivot($relObj->relatedPivotKey, $related->getKey());
                }

                $relObj->detach();
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'related' => function ($relatedId) {
                throw new \Exception();
            },

            'related_method' => function () {
                throw new \Exception();
            },

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
        return [
            'related' => ['not_null'],

            'related_id' => ['integer'],
        ];
    }

    public static function getTraits()
    {
        return [
            ModelFeatureService::class,
        ];
    }
}
