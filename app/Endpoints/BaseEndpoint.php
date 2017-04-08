<?php

namespace Api\Endpoints;

/**
 * Base endpoint.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class BaseEndpoint extends AbstractEndpoint
{
    /**
     * @var string
     */
    public $uri = '/';

    /**
     * Register endpoints relative to this endpoint uri.
     *
     * @return void
     */
    public function register()
    {
        $this->endpoints
            ->add(Image\Endpoint::class);
    }
}
