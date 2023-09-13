<?php

namespace OmarElnaghy\LaraDateFilters;


use Illuminate\Support\ServiceProvider as laravelServiceProvider;

class ServiceProvider extends laravelServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/lara_date_filter.php', 'lara_date_filter'
        );
    }

    public function boot()
    {
        //
    }
}
