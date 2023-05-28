<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\ORM\Eloquent\Service\Feature\ExpandsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\FieldsFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\GroupByFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\LimitFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Feature\OrderByFeatureService;
use FunctionalCoding\ORM\Eloquent\Service\Pagination\CursorPaginationService;
use FunctionalCoding\ORM\Eloquent\Service\Pagination\OffsetPaginationService;
use FunctionalCoding\Service;

class PaginationListService extends Service
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
            'cursor' => function () {
                throw new \Exception();
            },

            'order_by' => function ($modelClass) {
                if (null == $modelClass::CREATED_AT) {
                    return (new $modelClass())->getKeyName().' desc';
                }

                return $modelClass::CREATED_AT.' desc';
            },

            'result' => function ($limit, $orderByArray, $query, $cursor = '', $page = '') {
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

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'cursor_id' => ['integer'],
        ];
    }

    public static function getTraits()
    {
        return [
            ExpandsFeatureService::class,
            FieldsFeatureService::class,
            LimitFeatureService::class,
            OrderByFeatureService::class,
            GroupByFeatureService::class,
        ];
    }
}
