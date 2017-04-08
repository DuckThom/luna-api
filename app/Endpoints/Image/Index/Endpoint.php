<?php

namespace Api\Endpoints\Image\Index;

use Api\Models\Image;
use Illuminate\Http\JsonResponse;
use Api\Endpoints\AbstractEndpoint;
use Illuminate\Support\Facades\Auth;

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
    public $uri = 'index';

    /**
     * Handle the request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        $limit = abs((int) app('request')->input('limit', 15));
        $limit = ($limit < static::MAX_LIST_LIMIT ? $limit : static::MAX_LIST_LIMIT);

        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = Image::limit($limit);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        $images = $query->get()->each(function ($image) {
            /** @var \Api\Models\Image $image */
            $image->url = $image->getUrl();
        });

        return JsonResponse::create([
            'images' => $images
        ], JsonResponse::HTTP_OK);
    }
}