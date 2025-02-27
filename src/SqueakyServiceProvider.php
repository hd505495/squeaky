<?php

namespace JonPurvis\Squeaky;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SqueakyServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        $this->bootPackageTranslations();

        // Language Specific Configs
        $this->mergeConfigFrom(base_path('vendor').'/jonpurvis/profanify/src/Config/profanities/ar.php', 'profanify-ar');
        $this->mergeConfigFrom(base_path('vendor').'/jonpurvis/profanify/src/Config/profanities/en.php', 'profanify-en');
        $this->mergeConfigFrom(base_path('vendor').'/jonpurvis/profanify/src/Config/profanities/it.php', 'profanify-it');
        $this->mergeConfigFrom(base_path('vendor').'/jonpurvis/profanify/src/Config/profanities/nl.php', 'profanify-nl');
        $this->mergeConfigFrom(base_path('vendor').'/jonpurvis/profanify/src/Config/profanities/pt_BR.php', 'profanify-pt_BR');

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
            ->name('clean')
            ->hasTranslations();
    }
}
