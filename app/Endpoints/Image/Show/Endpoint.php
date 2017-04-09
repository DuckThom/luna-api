<?php

namespace Api\Endpoints\Image\Show;

use Api\Models\Image;
use Illuminate\Http\Response;
use Api\Responses\ApiResponse;
use Api\Endpoints\AbstractEndpoint;
use Illuminate\Support\Facades\Cache;

/**
 * Image show endpoint.
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
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(string $slug)
    {
        /** @var \Api\Models\Image $image */
        $image = Image::where('slug', $slug)->first();

        if ($image === null) {
            return ApiResponse::error([
                'message' => Image::NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        }

        $image->addView();

        $imageContent = Cache::store('file')->remember('image.'.$slug, 15, function () use ($image) {
            return $image->getContent();
        });

        return response($imageContent, Response::HTTP_OK, [
            'Content-Type' => $image->getMimeType(),
        ]);
    }
}
