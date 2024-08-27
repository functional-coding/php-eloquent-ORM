<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ModelFeatureService;
use FunctionalCoding\Service;

class PivotCreateService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'model#related' => function ($model, $related, $relatedMethod) {
                $model->{$relatedMethod}()->attach($related->getKey());
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'related' => function () {
                throw new \Exception();
            },

            'related_method' => function () {
                throw new \Exception();
            },

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
        return [
            'related' => ['not_null'],

            'related_id' => ['required', 'integer'],
        ];
    }

    public static function getTraits()
    {
        return [
            ModelFeatureService::class,
        ];
    }
}
