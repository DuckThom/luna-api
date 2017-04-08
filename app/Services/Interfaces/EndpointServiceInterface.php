<?php

namespace Api\Services\Interfaces;

use Api\Collections\EndpointCollection;

/**
 * Endpoint service interface
 *
 * @author  Thomas Wiringa <thomas.wiringa@gmail.com>
 */
interface EndpointServiceInterface
{
    /**
     * Get all the registered API endpoints.
     *
     * @return EndpointCollection
     */
    public function getEndpoints(): EndpointCollection;

    /**
     * Get a route by request method.
     *
     * @param  string  $method  Defaults to the current request method
     * @return EndpointCollection
     */
    public function getEndpointsByMethod(string $method = null): EndpointCollection;

    /**
     * Check if the endpoint exists for the specified or current request method.
     *
     * @param  string  $endpoint  Endpoint URI
     * @param  string|null  $method  Defaults to the current request method
     * @return bool
     */
    public function hasEndpoint(string $endpoint, string $method = null): bool;
}