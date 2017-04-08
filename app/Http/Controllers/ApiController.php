<?php

namespace Api\Http\Controllers;

/**
 * API Controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class ApiController extends Controller
{
    protected $router;

    /**
     * ApiController constructor.
     */
    public function __construct(RoutingServiceInterface $routingService)
    {
        $this->middleware('auth:api');

        $this->router = $routingService;
    }

    public function handle()
    {

    }
}