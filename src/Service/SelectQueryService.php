<?php

namespace FunctionalCoding\ORM\Eloquent\Service;

use FunctionalCoding\Service;

class SelectQueryService extends Service
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
                $columns = $query->getQuery()->columns;
                $model = $query->getModel();
                $selectQuery = $model->query();
                $query = (clone $query)->select($model->getKeyName());
                $ids = $query->get()->modelKeys();

                $selectQuery->getQuery()->select($columns);
                $selectQuery->whereIn($model->getKeyName(), $ids);

                if (!empty($ids)) {
                    if ('string' == $model->getKeyType()) {
                        foreach ($ids as $i => $id) {
                            $ids[$i] = '\''.$id.'\'';
                        }
                    }

                    $selectQuery->orderByRaw('FIELD('.$model->getKeyName().','.implode(',', $ids).')');
                }

                return $selectQuery;
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
        return [];
    }
}
