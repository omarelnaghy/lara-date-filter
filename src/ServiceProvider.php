<?php

declare(strict_types=1);

namespace OmarElnaghy\LaraDateFilters;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lara-date-filter')
            ->hasConfigFile('lara_date_filter');
    }
}
