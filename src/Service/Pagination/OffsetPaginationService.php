<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Pagination;

use FunctionalCoding\ORM\Eloquent\Service\Feature\OptimizeQueryBuilderFeatureService;
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
            'result' => function ($limit, $optimizeQueryBuilder, $page, $query) {
                $countQuery = (clone $query)->toBase();
                $countQuery->limit = null;
                $countQuery->offset = null;

                return app()->makeWith(LengthAwarePaginator::class, [
                    'items' => $optimizeQueryBuilder($query)->get(),
                    'total' => $countQuery->count(),
                    'perPage' => $limit,
                    'currentPage' => $page,
                    'options' => [
                        'path' => Paginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    ],
                ]);
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
        return [
            OptimizeQueryBuilderFeatureService::class,
        ];
    }
}
