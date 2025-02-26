<?php

namespace JonPurvis\Clean;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CleanServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        // Language Specific Configs
        $this->mergeConfigFrom(base_path('vendor').'/jonpurvis/profanify/src/Config/profanities/en.php', 'profanify-en');

        // General Configs
        $this->mergeConfigFrom(base_path('vendor').'/jonpurvis/profanify/src/Config/tolerated.php', 'profanify-tolerated');
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('clean');
    }
}
