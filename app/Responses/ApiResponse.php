<?php

namespace Api\Responses;

use Illuminate\Http\JsonResponse;

/**
 * Api response
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class ApiResponse extends JsonResponse
{
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    /**
     * Return a json success response.
     *
     * @param  array  $data
     * @param  int  $code
     * @param  array  $headers
     * @return ApiResponse
     */
    public static function success(array $data = [], int $code = null, array $headers = []): ApiResponse
    {
        $code = ($code ?: static::HTTP_OK);

        return new static([
            'status' => static::STATUS_SUCCESS,
            'code' => $code,
            'payload' => $data,
        ], $code, $headers);
    }

    /**
     * Return a json response.
     *
     * @param  array  $data
     * @param  int  $code
     * @param  array  $headers
     * @return ApiResponse
     */
    public static function error(array $data = [], int $code = null, array $headers = []): ApiResponse
    {
        $code = ($code ?: static::HTTP_BAD_REQUEST);

        return new static([
            'status' => static::STATUS_ERROR,
            'code' => $code,
            'payload' => $data,
        ], $code, $headers);
    }
}