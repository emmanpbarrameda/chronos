<?php

namespace Ianstudios\Chronos;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ChronosServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('chronos')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_chronos_audits_table');
    }
}