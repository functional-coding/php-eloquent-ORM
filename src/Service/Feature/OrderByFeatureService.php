<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Feature;

use FunctionalCoding\Service;

class OrderByFeatureService extends Service
{
    public static function getBindNames()
    {
        return [
            'available_order_by' => 'available options for {{order_by}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'query.order_by_array' => function ($orderByArray, $query) {
                foreach ($orderByArray as $key => $direction) {
                    $query->orderBy($key, $direction);
                }
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'available_order_by' => function ($modelClass) {
                if (null == $modelClass::CREATED_AT) {
                    return [(new $modelClass())->getKeyName().' desc', (new $modelClass())->getKeyName().' asc'];
                }

                return [$modelClass::CREATED_AT.' desc', $modelClass::CREATED_AT.' asc'];
            },

            'order_by_array' => function ($modelClass, $orderBy) {
                $model = new $modelClass();
                $orderBy = preg_replace('/\s+/', ' ', $orderBy);
                $orderBy = preg_replace('/\s*,\s*/', ',', $orderBy);
                $orders = explode(',', $orderBy);
                $array = [];

                foreach ($orders as $order) {
                    $key = explode(' ', $order)[0];
                    $direction = str_replace($key, '', $order);

                    $array[$key] = ltrim($direction);
                }

                if (array_keys($array)[count($array) - 1] != $model->getKeyName()) {
                    $array[$model->getKeyName()] = end($array);
                }

                return $array;
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
            'order_by' => ['string', 'some_of_array:{{available_order_by}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
