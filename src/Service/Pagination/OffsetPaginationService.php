<?php

namespace FunctionalCoding\Illuminate\Service\Pagination;

use FunctionalCoding\Illuminate\Service\Feature\LimitFeatureService;
use FunctionalCoding\Illuminate\Service\SelectQueryService;
use FunctionalCoding\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class OffsetPaginationService extends Service
{
    public static function getArrBindNames()
    {
        return [];
    }

    public static function getArrCallbacks()
    {
        return [
            'query.skip' => function ($query, $skip) {
                $query->skip($skip);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'result' => function ($limit, $page, $query, $selectQuery) {
                $query = (clone $query)->toBase();
                $query->limit = null;
                $query->offset = null;

                return app()->makeWith(LengthAwarePaginator::class, [
                    'items' => $selectQuery->get(),
                    'total' => $query->count(),
                    'perPage' => $limit,
                    'currentPage' => $page,
                    'options' => [
                        'path' => Paginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    ],
                ]);
            },

            'select_query' => function ($query) {
                return [SelectQueryService::class, [
                    'query' => $query,
                ]];
            },

            'skip' => function ($limit, $page) {
                return ($page - 1) * $limit;
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
            'page' => ['required', 'integer', 'min:1'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            LimitFeatureService::class,
        ];
    }
}
