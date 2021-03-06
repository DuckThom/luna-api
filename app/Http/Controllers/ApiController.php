<?php

namespace Api\Http\Controllers;

use Illuminate\Http\Request;
use Api\Services\Interfaces\EndpointServiceInterface;

/**
 * API Controller.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class ApiController extends Controller
{
    /**
     * @var EndpointServiceInterface
     */
    protected $endpointService;

    /**
     * ApiController constructor.
     *
     * @param  EndpointServiceInterface  $endpointService
     */
    public function __construct(EndpointServiceInterface $endpointService)
    {
        $this->middleware('auth:api');

        $this->endpointService = $endpointService;
    }

    public function handle(Request $request)
    {
        $method = strtolower($request->getMethod());
        $routes = $this->endpointService->getEndpointsByMethod($method);
    }
}
