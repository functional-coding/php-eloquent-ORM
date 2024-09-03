<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Service\Feature;

use Illuminate\Database\Eloquent\Model;
use SimplifyServiceLayer\Service;

class FieldsFeatureService extends Service
{
    public static function getBindNames()
    {
        return [
            'available_fields' => 'available options for {{fields}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'query#fields' => function ($availableFields, $query, $fields = '') {
                $fields = $fields ? preg_split('/\s*,\s*/', $fields) : $availableFields;
                $modelClass = get_class($query->getModel());
                $model = new $modelClass();
                $fields = array_diff($fields, array_keys($model->toArray()));

                foreach ($fields as $i => $field) {
                    $fields[$i] = $model->getTable().'.'.$field;
                }

                $query->select($fields);
            },

            'result#fields@defer' => function ($availableFields, $modelClass, $result, $fields = '') {
                $fields = $fields ? preg_split('/\s*,\s*/', $fields) : $availableFields;
                $model = new $modelClass();
                $fields = array_intersect($fields, array_keys($model->toArray()));

                if ($result instanceof Model) {
                    $collection = $result->newCollection([$result]);
                } else {
                    $collection = $result;
                }

                foreach ($collection as $model) {
                    foreach ($fields as $field) {
                        $model[$field] = $model->{$field};
                    }
                }
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'available_fields' => function ($modelClass) {
                $model = new $modelClass();

                return array_diff(array_merge(
                    array_keys($model->toArray()), // appends
                    $model->getFillable(),
                    $model->getGuarded(),
                ), $model->getHidden());
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
            'fields' => ['string', 'some_of_array:{{available_fields}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
