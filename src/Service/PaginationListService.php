<?php

namespace FunctionalCoding\Illuminate\Service;

use FunctionalCoding\Illuminate\Service\Feature\ExpandsFeatureService;
use FunctionalCoding\Illuminate\Service\Feature\FieldsFeatureService;
use FunctionalCoding\Illuminate\Service\Feature\LimitFeatureService;
use FunctionalCoding\Illuminate\Service\Feature\OrderByFeatureService;
use FunctionalCoding\Illuminate\Service\Pagination\CursorPaginationService;
use FunctionalCoding\Illuminate\Service\Pagination\OffsetPaginationService;
use FunctionalCoding\Service;

class PaginationListService extends Service
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
            'cursor' => function () {
                throw new \Exception();
            },

            'result' => function ($cursor = '', $limit, $orderByArray, $page = '', $query) {
                if ('' !== $page) {
                    return [OffsetPaginationService::class, [
                        'limit' => $limit,
                        'page' => $page,
                        'query' => $query,
                    ], [
                        'limit' => '{{limit}}',
                        'page' => '{{page}}',
                    ]];
                }

                return [CursorPaginationService::class, [
                    'cursor' => $cursor,
                    'limit' => $limit,
                    'order_by_array' => $orderByArray,
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
        return [
            'cursor_id' => ['integer'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            ExpandsFeatureService::class,
            FieldsFeatureService::class,
            LimitFeatureService::class,
            OrderByFeatureService::class,
        ];
    }
}
