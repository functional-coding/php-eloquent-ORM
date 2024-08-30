<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use SimplifyServiceLayer\Service;

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
