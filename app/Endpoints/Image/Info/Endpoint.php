<?php

namespace Api\Endpoints\Image\Info;

use Api\Models\Image;
use Illuminate\Http\Response;
use Api\Responses\ApiResponse;
use Api\Endpoints\AbstractEndpoint;
use Illuminate\Support\Facades\Cache;

/**
 * Image info endpoint.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class Endpoint extends AbstractEndpoint
{
    const MAX_LIST_LIMIT = 50;

    /**
     * @var string
     */
    public $uri = 'info/{id}';

    /**
     * @var string
     */
    public $name = 'image.info';

    /**
     * Handle the request.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(string $id)
    {
        /** @var \Api\Models\Image $image */
        $image = Image::find($id);

        if ($image === null) {
            return ApiResponse::error([
                'message' => Image::NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::success($image->toArray() + [
            'url' => $image->getUrl(),
            'message' => Image::DETAILS,
        ]);
    }
}
