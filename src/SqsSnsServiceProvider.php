<?php

namespace Zackyjack\LaravelSqsSns;

use Illuminate\Support\ServiceProvider;
use Zackyjack\LaravelSqsSns\Queue\Connectors\SqsSnsConnector;

class SqsSnsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // nothing to register
    }

    /**
     * Bootstraps the 'queue' with a new connector 'sqs-sns'
     *
     * @return void
     */
    public function boot()
    {
        $this->app['queue']->extend('sqs-sns', function () {
            return new SqsSnsConnector;
        });
    }
}
