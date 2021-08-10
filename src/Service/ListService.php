<?php

namespace FunctionalCoding\Illuminate\Service;

use FunctionalCoding\Illuminate\Service\Feature\ExpandsFeatureService;
use FunctionalCoding\Illuminate\Service\Feature\FieldsFeatureService;
use FunctionalCoding\Illuminate\Service\Feature\OrderByFeatureService;
use FunctionalCoding\Service;

class ListService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => function ($query) {
                return $query->get();
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
            OrderByFeatureService::class,
        ];
    }
}
