<?php

namespace FunctionalCoding\Illuminate\Feature;

use FunctionalCoding\Service;
use FunctionalCoding\Illuminate\Feature\QueryFeatureService;

class LimitFeatureService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [
            'query.limit' => function ($limit, $query) {

                $query->take($limit);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'limit' => function () {

                return 30;
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
            'limit'
                => ['required', 'integer', 'max:120', 'min:1'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}