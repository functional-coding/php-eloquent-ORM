<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Feature;

use FunctionalCoding\Service;

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

                $query->select($fields);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'available_fields' => function ($modelClass) {
                $model = new $modelClass();

                return array_merge($model->getFillable(), $model->getGuarded());
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
