<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ExpandsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\FieldsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\LimitFeatureService;
use FunctionalCoding\Service;

class RandomListService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'query.order_by' => function ($query) {
                $query->orderByRaw('RAND()');
            },
        ];
    }

    public static function getLoaders()
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
            ExpandsFeatureService::class,
            FieldsFeatureService::class,
            LimitFeatureService::class,
        ];
    }
}
