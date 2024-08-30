<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service\Feature;

use SimplifyServiceLayer\Service;

class LimitFeatureService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'query#limit' => function ($limit, $query) {
                $query->take($limit);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'limit' => function () {
                return 30;
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
            'limit' => ['required', 'integer', 'max:120', 'min:1'],
        ];
    }

    public static function getTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
