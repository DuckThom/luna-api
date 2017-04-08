<?php

namespace Api\Http\Controllers;

use Api\Facades\LastFm;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Music controller.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class MusicController extends Controller
{
    /**
     * Get the currently playing track.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function current()
    {
        try {
            $responseBody = Cache::store('file')->remember('lastfm.currentTrack', 1, function () {
                $response = LastFm::currentTrack();

                return (string) $response->getBody();
            });
        } catch (\Exception $e) {
            app('log')->error($e->getMessage(), $e->getTrace());

            return $this->jsonError([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->jsonSuccess([
            'message' => null,
            'tracks' => \GuzzleHttp\json_decode($responseBody),
        ]);
    }
}
