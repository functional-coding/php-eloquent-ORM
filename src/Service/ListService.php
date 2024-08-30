<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service;

use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\ExpandsFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\FieldsFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\GroupByFeatureService;
use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\OrderByFeatureService;
use SimplifyServiceLayer\Service;

class ListService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [];
    }

    public static function getLoaders()
    {
        return [
            'result' => function ($query) {
                return $query->get();
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
            OrderByFeatureService::class,
            GroupByFeatureService::class,
        ];
    }
}
