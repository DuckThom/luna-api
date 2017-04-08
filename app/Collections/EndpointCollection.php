<?php

namespace Api\Collections;

use Api\Endpoints\AbstractEndpoint;
use Illuminate\Support\Collection;

/**
 * Endpoint collection
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class EndpointCollection extends Collection
{
    /**
     * Add a new endpoint
     *
     * @param  string  $class  Class name of an Endpoint
     * @param  string  $uri  Base uri of the endpoint
     * @return $this
     */
    public function add(string $class, string $uri = '/')
    {
        /** @var AbstractEndpoint $endpoint */
        $endpoint = new $class($uri);
        $endpoint->register();

        $this->put($endpoint->uri, $endpoint);

        return $this;
    }
}