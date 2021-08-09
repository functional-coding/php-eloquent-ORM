<?php

namespace FunctionalCoding\Illuminate\Providers;

use FunctionalCoding\Illuminate\Validator;
use FunctionalCoding\Service;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory as ValidationFactory;

class ServiceValidationProvider extends ServiceProvider
{
    public function boot()
    {
        Service::setResolverForGetValidationErrors(function ($data = [], $ruleLists = [], $names = []) {
            $app = Container::getInstance();
            $factory = $app->make(ValidationFactory::class);
            $factory->resolver(function ($tr, array $data, array $rules, array $messages, array $names) {
                return $app->make(
                    Validator::class,
                    compact('tr', 'data', 'rules', 'messages', 'names')
                );
            });

            $validator = $factory->make($data, $ruleLists, $messages = [], $names);
            $validator->passes();

            return $validator->errors()->all();
        });
    }
}
