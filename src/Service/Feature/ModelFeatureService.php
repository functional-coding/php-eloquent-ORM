<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service\Feature;

use SimplifyServiceLayer\Service;

class ModelFeatureService extends Service
{
    public static function getBindNames()
    {
        return [
            'model' => 'model for {{id}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'query#id' => function ($id, $query) {
                $query->where($query->getModel()->getKeyName(), $id);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'model' => function ($query) {
                return $query->first();
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
            'id' => ['required', 'integer'],

            'model' => ['not_null'],
        ];
    }

    public static function getTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
