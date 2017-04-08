<?php

namespace Api\Services;

use GuzzleHttp\Client;

/**
 * Class LastFm.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class LastFm
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * LastFm constructor.
     *
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the most recently played track.
     *
     * @param  int  $limit
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function currentTrack(int $limit = 1)
    {
        return $this->client->get('2.0', [
            'query' => [
                'user' => config('lastfm.username'),
                'api_key' => config('lastfm.api_key'),
                'format' => 'json',
                'method' => 'user.getrecenttracks',
                'limit' => $limit,
            ],
        ]);
    }
}
