<?php

namespace FunctionalCoding\Illuminate\Service;

use FunctionalCoding\Illuminate\Service\Feature\ExpandsFeatureService;
use FunctionalCoding\Illuminate\Service\Feature\FieldsFeatureService;
use FunctionalCoding\Illuminate\Service\Feature\LimitFeatureService;
use FunctionalCoding\Service;

class RandomListService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [
            'query.order_by' => function ($query) {
                $query->orderByRaw('RAND()');
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => function ($selectQuery) {
                return $selectQuery->get();
            },

            'select_query' => function ($query) {
                return [SelectQueryService::class, [
                    'query' => $query,
                ]];
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
            ExpandsFeatureService::class,
            FieldsFeatureService::class,
            LimitFeatureService::class,
        ];
    }
}
