<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service\Pagination;

use SimplifyServiceLayer\ORM\Eloquent\Service\Feature\OptimizeQueryBuilderFeatureService;
use SimplifyServiceLayer\Service;

class CursorPaginationService extends Service
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
            'result' => function ($limit, $optimizeQueryBuilder, $orderByArray, $query, $cursor = '') {
                $wheres = [];
                $result = [];

                foreach ($orderByArray as $column => $direction) {
                    if (empty($cursor)) {
                        break;
                    }

                    if ('asc' == $direction) {
                        $wheres[] = [$column, '>', $cursor->{$column}];
                    } else {
                        $wheres[] = [$column, '<', $cursor->{$column}];
                    }
                }

                do {
                    $newQuery = clone $query;

                    foreach ($wheres as $i => $where) {
                        if ($where == end($wheres)) {
                            $newQuery->where($where[0], $where[1], $where[2]);
                        } else {
                            $newQuery->where($where[0], '=', $where[2]);
                        }
                    }

                    array_pop($wheres);

                    $list = $optimizeQueryBuilder($newQuery)->get();
                    $limit = $limit - count($list);
                    $result = array_merge($result, $list->all());
                } while (0 != $limit && 0 != count($wheres));

                return $query->getModel()->newCollection($result);
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
            OptimizeQueryBuilderFeatureService::class,
        ];
    }
}
