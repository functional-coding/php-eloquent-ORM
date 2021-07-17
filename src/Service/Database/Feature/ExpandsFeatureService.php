<?php

namespace Illuminate\Extend\Service\Database\Feature;

use Illuminate\Extend\Collection;
use Illuminate\Extend\Model;
use Illuminate\Extend\Service;
use Illuminate\Extend\Service\Database\Feature\QueryFeatureService;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpandsFeatureService extends Service
{
    public static function getArrBindNames()
    {
        return [
            'available_expands'
                => 'options for {{expands}}',
        ];
    }

    public static function getArrCallbackLists()
    {
        return [
            'result.expands' => function ($expands, $result) {

                if ( $result instanceof Model )
                {
                    $expands = preg_split('/\s*,\s*/', $expands);
                    $collection = $result->newCollection();
                    $collection->push($result);
                }
                else if ( $result instanceof Collection )
                {
                    $collection = $result;
                }
                else if ( $result instanceof LengthAwarePaginator )
                {
                    $collection = $result->getCollection();
                }
                else
                {
                    throw new \Exception;
                }

                $collection->loadVisible($expands);
            },
        ];
    }

    public static function getArrLoaders()
    {
        return [
            'available_expands' => function () {

                throw new \Exception;
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
            'expands'
                => ['string', 'several_in:{{available_expands}}'],
        ];
    }

    public static function getArrTraits()
    {
        return [
            QueryFeatureService::class,
        ];
    }
}
