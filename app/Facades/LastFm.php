<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * LastFM facade
 *
 * @method static \Psr\Http\Message\ResponseInterface currentTrack()
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class LastFm extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lastfm';
    }
}