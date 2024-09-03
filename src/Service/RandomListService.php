<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service;

use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\ExpandsFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\FieldsFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\GroupByFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\LimitFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\OptimizeQueryBuilderFeatureService;
use SimplifyServiceLayer\Service;

class RandomListService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'query#order_by' => function ($query) {
                $query->orderByRaw('RAND()');
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'result' => function ($optimizeQueryBuilder, $query) {
                return $optimizeQueryBuilder($query)->get();
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
            OptimizeQueryBuilderFeatureService::class,
            ExpandsFeatureService::class,
            FieldsFeatureService::class,
            LimitFeatureService::class,
            GroupByFeatureService::class,
        ];
    }
}
