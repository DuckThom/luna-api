<?php

namespace Api\Services;

use Api\Endpoints\BaseEndpoint;
use Api\Collections\EndpointCollection;
use Api\Services\Interfaces\EndpointServiceInterface;

/**
 * Endpoint service.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class EndpointService implements EndpointServiceInterface
{
    /**
     * @var EndpointCollection
     */
    protected $endpoints;

    /**
     * EndpointService constructor.
     *
     * @param  $app
     */
    public function __construct($app)
    {
        $baseEndpoint = new BaseEndpoint;
        $baseEndpoint->register();
        $baseEndpoint->resolve($app);

        $this->endpoints = $baseEndpoint->getEndpoints();
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoints(): EndpointCollection
    {
        return $this->endpoints;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpointsByMethod(string $method = null): EndpointCollection
    {
        // TODO: Implement getEndpointsByMethod() method.
    }

    /**
     * {@inheritdoc}
     */
    public function hasEndpoint(string $endpoint, string $method = null): bool
    {
        // TODO: Implement hasEndpoint() method.
    }
}
