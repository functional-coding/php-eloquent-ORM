<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Feature;

use FunctionalCoding\Service;

class GroupByFeatureService extends Service
{
    public static function getBindNames()
    {
        return [
            'available_group_by' => 'available options for {{group_by}}',
        ];
    }

    public static function getCallbacks()
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

    public static function getLoaders()
    {
        return [
            'available_group_by' => function () {
                return [];
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
            'group_by' => ['string', 'some_of_array:{{available_group_by}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
