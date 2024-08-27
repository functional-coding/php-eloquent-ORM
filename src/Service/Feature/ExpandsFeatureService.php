<?php

namespace FunctionalCoding\ORM\Eloquent\Service\Feature;

use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpandsFeatureService extends Service
{
    public static function getBindNames()
    {
        return [
            'available_expands' => 'available options for {{expands}}',
        ];
    }

    public static function getCallbacks()
    {
        return [
            'result#expands' => function ($expands, $result) {
                $expands = preg_split('/\s*,\s*/', $expands);

                if ($result instanceof Model) {
                    $collection = $result->newCollection();
                    $collection->push($result);
                } elseif ($result instanceof Collection) {
                    $collection = $result;
                } elseif ($result instanceof LengthAwarePaginator) {
                    $collection = $result->getCollection();
                } else {
                    throw new \Exception();
                }

                $collection->load($expands);
            },
        ];
    }

    public static function getLoaders()
    {
        return [
            'available_expands' => function () {
                throw new \Exception();
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
            'expands' => ['string', 'some_of_array:{{available_expands}}'],
        ];
    }

    public static function getTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
