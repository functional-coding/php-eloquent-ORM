<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Feature;

use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Model;

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
            'query.fields' => function ($availableFields, $fields = '', $query) {
                $fields = $fields ? preg_split('/\s*,\s*/', $fields) : $availableFields;
                $modelClass = get_class($query->getModel());
                $model = new $modelClass;
                $fields = array_diff($fields, array_keys($model->toArray()));

                foreach ($fields as $i => $field) {
                    $fields[$i] = $model->getTable().'.'.$field;
                }

                $query->select($fields);
            },

            'result.fields:after_commit' => function ($availableFields, $fields = '', $modelClass, $result) {
                $fields = $fields ? preg_split('/\s*,\s*/', $fields) : $availableFields;
                $model = new $modelClass;
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

                return array_merge(
                    array_keys($model->toArray()), // appends
                    $model->getFillable(),
                    $model->getGuarded(),
                );
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
