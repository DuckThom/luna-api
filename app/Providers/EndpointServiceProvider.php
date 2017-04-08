<?php

namespace Api\Providers;

use Api\Endpoints\BaseEndpoint;
use Illuminate\Support\ServiceProvider;

/**
 * Endpoint service provider
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class EndpointServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $baseEndpoint = new BaseEndpoint;
        $baseEndpoint->register();
        $baseEndpoint->resolve($this->app);
    }
}