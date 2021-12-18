<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ExpandsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\FieldsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\OrderByFeatureService;
use FunctionalCoding\Service;

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
        ];
    }
}
