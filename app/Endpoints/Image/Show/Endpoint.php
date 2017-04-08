<?php

namespace Api\Endpoints\Image\Show;

use Api\Endpoints\AbstractEndpoint;

/**
 * Image index endpoint
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class Endpoint extends AbstractEndpoint
{
    const MAX_LIST_LIMIT = 50;

    /**
     * @var string
     */
    public $uri = 'show/{slug}';

    /**
     * @var string
     */
    public $name = 'image.show';

    /**
     * Handle the request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        //
    }
}