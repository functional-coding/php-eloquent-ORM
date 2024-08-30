<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use SimplifyServiceLayer\Service;

class ServiceJsonApiProvider extends ServiceProvider
{
    public function boot()
    {
        $restify = function ($data) use (&$restify) {
            if (!is_a($data, Model::class) && !is_a($data, Collection::class)) {
                return $data;
            }

            $isModel = $data instanceof Model ? true : false;
            $return = [];
            $items = $isModel ? [$data] : $data->all();

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

        Service::setResponseResolver(function ($result, $errors) {
            if ($errors) {
                $msgs = [];
                \array_walk_recursive($errors, function ($value) use (&$msgs) {
                    $msgs[] = $value;
                });

                return ['errors' => $msgs];
            }

            if ($result instanceof LengthAwarePaginator) {
                return [
                    'result' => [
                        'data' => $restify($result->getCollection()),
                        'current_page' => $result->currentPage(),
                        'per_page' => $result->perPage(),
                        'last_page' => $result->lastPage(),
                        'total' => $result->total(),
                    ]
                ];
            }

            return [
                'result' => $restify($result),
            ];
        });
    }
}
