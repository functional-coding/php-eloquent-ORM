<?php

namespace FunctionalCoding\Illuminate;

use FunctionalCoding\Service;
use FunctionalCoding\Illuminate\Feature\ModelFeatureService;

class PivotCreateService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [
            'model.related' => function ($model, $related, $relatedMethod) {

                $model->{$relatedMethod}()->attach($related->getKey());
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'related' => function () {

                throw new \Exception;
            },

            'related_method' => function () {

                throw new \Exception;
            },

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
        return [
            'related'
                => ['not_null'],

            'related_id'
                => ['required', 'integer'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            ModelFeatureService::class,
        ];
    }
}
