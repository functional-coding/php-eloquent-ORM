<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Feature;

use FunctionalCoding\Service;

class GroupByFeatureService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'available_group_by' => 'available options for {{group_by}}',
        ];
    }

    public static function getArrCallbacks()
    {
        return [
            'query.group_by' => function ($groupBy, $query) {
                $groupBy = preg_replace('/\s*,\s*/', ',', $groupBy);
                $arr = \explode(',', $groupBy);

                foreach ($arr as $key) {
                    $query->groupBy($key);
                }
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_group_by' => function () {
                throw new \Exception();
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
            'group_by' => ['string', 'some_of_array:{{available_group_by}}'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
