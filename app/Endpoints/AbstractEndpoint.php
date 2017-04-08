<?php

namespace Api\Endpoints;

use Laravel\Lumen\Application;
use Api\Collections\EndpointCollection;
use Api\Exceptions\MissingUriException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Abstract endpoint
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
abstract class AbstractEndpoint
{
    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $method = 'get';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var array
     */
    public $middleware = [];

    /**
     * @var EndpointCollection
     */
    protected $endpoints;

    /**
     * AbstractEndpoint constructor.
     *
     * @param  string|null  $uri
     * @throws MissingUriException
     */
    public function __construct(string $uri = null)
    {
        if ($uri === null && $this->uri === null) {
            throw new MissingUriException(get_class($this));
        } else if ($uri !== null) {
            $this->uri = $uri.'/'.$this->uri;
        }

        $this->endpoints = new EndpointCollection;
    }

    /**
     * Register child endpoints.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Resolve the stored routes in the route collection.
     *
     * @param  Application  $app
     */
    public function resolve($app)
    {
        $this->getEndpoints()->each(function ($endpoint) use ($app) {
            $app->{$endpoint->method}($endpoint->uri, [
                'as' => $endpoint->name,
                'middleware' => $endpoint->middleware,
                function () use ($endpoint) {
                    return $endpoint->handle();
                }
            ]);

            $endpoint->resolve($app);
        });
    }

    /**
     * Get the endpoints.
     *
     * @return EndpointCollection
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * Handle the request.
     *
     * By default, throw a NotFoundHttpException so not every route can be accessed by default
     *
     * @throws NotFoundHttpException
     */
    public function handle()
    {
        throw new NotFoundHttpException("404 Not Found: ".app('request')->getUri());
    }
}