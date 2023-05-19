<?php

namespace FunctionalCoding\ORM\Eloquent\Providers;

use FunctionalCoding\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ServiceTransactionProvider extends ServiceProvider
{
    public function boot()
    {
        Service::addOnBeforeRunCallback(function () {
            DB::beginTransaction();
        });
        Service::addOnSuccessCallback(function () {
            DB::commit();
        });
        Service::addOnFailCallback(function () {
            DB::rollBack();
        });
    }
}
