<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Pagination;

use FunctionalCoding\ORM\Eloquent\Service\SelectQueryService;
use FunctionalCoding\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class OffsetPaginationService extends Service
{
    public static function getBindNames()
    {
        return [];
    }

    public static function getCallbacks()
    {
        return [
            'query.skip' => function ($query, $skip) {
                $query->skip($skip);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'count_query' => function ($query) {
                $countQuery = (clone $query)->toBase();
                $countQuery->limit = null;
                $countQuery->offset = null;

                return $countQuery;
            },

            'result' => function ($limit, $page, $countQuery, $selectQuery) {
                return app()->makeWith(LengthAwarePaginator::class, [
                    'items' => $selectQuery->get(),
                    'total' => $countQuery->count(),
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

    public static function getPromiseLists()
    {
        return [];
    }

    public static function getRuleLists()
    {
        return [
            'page' => ['required', 'integer', 'min:1'],
        ];
    }

    public static function getTraits()
    {
        return [];
    }
}
