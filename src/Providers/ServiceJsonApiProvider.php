<?php

namespace FunctionalCoding\ORM\Eloquent\Providers;

use FunctionalCoding\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ServiceJsonApiProvider extends ServiceProvider
{
    public function boot()
    {
        $restify = function ($result) use (&$restify) {
            if ($result instanceof AbstractPaginator) {
                $result = $result->getCollection();
            }
            if (!is_a($result, Model::class) && !is_a($result, Collection::class)) {
                return $result;
            }

            $isModel = $result instanceof Model ? true : false;
            $return = [];
            $items = $isModel ? [$result] : $result->all();

            foreach ($items as $i => $item) {
                $type = array_flip(Relation::morphMap())[get_class($item)];
                $value = [];
                $value['_type'] = $type;
                $value['_attributes'] = $item->attributesToArray();
                $value['_relations'] = [];

                foreach ($item->getRelations() as $key => $relation) {
                    $value['_relations'][$key] = $restify($relation);
                }

                $return[] = $value;
            }

            return $isModel ? $return[0] : $return;
        };

        Service::setResponseResultResolver(function ($result) use ($restify) {
            return $restify($result);
        });
        Service::setResponseErrorsResolver(function ($errors) {
            $msgs = [];
            \array_walk_recursive($errors, function ($value) use (&$msgs) {
                $msgs[] = $value;
            });

            return $msgs;
        });
    }
}
