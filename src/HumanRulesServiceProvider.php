<?php

namespace HumanReadable\HumanRules;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HumanRulesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('human-rules')
            ->hasConfigFile('human-rules')
            ->hasTranslations();
    }

    public function bootingPackage()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'human-rules');
    }
}
