<?php

namespace Api\Endpoints\Image;

use Api\Endpoints\AbstractEndpoint;

/**
 * Image endpoint service
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class Endpoint extends AbstractEndpoint
{
    /**
     * @var string
     */
    public $uri = 'image';

    /**
     * Register the route
     *
     * @return void
     */
    public function register()
    {
        $this->endpoints
            ->add(Show\Endpoint::class, $this->uri)
            ->add(Index\Endpoint::class, $this->uri);
    }
}