<?php

namespace Api\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    const STATUS_ERROR = "error";
    const STATUS_SUCCESS = "success";

    /**
     * Return a json success response
     *
     * @param  array  $data
     * @param  int  $code
     * @param  array  $headers
     * @return JsonResponse
     */
    public function jsonSuccess(array $data = [], int $code = null, array $headers = []): JsonResponse
    {
        $code = ($code ?: Response::HTTP_OK);

        return response()->json([
            "status" => static::STATUS_SUCCESS,
            "code" => $code,
            "payload" => $data
        ], $code, $headers);
    }

    /**
     * Return a json response
     *
     * @param  array  $data
     * @param  int  $code
     * @param  array  $headers
     * @return JsonResponse
     */
    public function jsonError(array $data = [], int $code = null, array $headers = []): JsonResponse
    {
        $code = ($code ?: Response::HTTP_BAD_REQUEST);

        return response()->json([
            "status" => static::STATUS_ERROR,
            "code" => $code,
            "payload" => $data
        ], $code, $headers);
    }
}
