<?php

namespace HumanReadable\HumanRules\Tests;

use HumanReadable\HumanRules\HumanRulesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            HumanRulesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.locale', 'es'); // o 'en', si quieres por defecto
        config()->set('human-rules.default_locale', 'es');
    }
}
