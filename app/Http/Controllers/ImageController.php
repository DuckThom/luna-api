<?php

namespace Api\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use Api\Models\Image;

/**
 * Image controller
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class ImageController extends Controller
{
    const MAX_LIST_LIMIT = 50;

    /**
     * Get the data for an image
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        /** @var \Api\Models\Image $image */
        $image = Image::where('slug', $slug)->first();

        if ($image === null) {
            return $this->imageNotFound();
        }

        $image->addView();

        $imageContent = Cache::store('file')->remember('image.'.$slug, 15, function () use ($image) {
            return $image->getContent();
        });

        return response($imageContent, Response::HTTP_OK, [
            'Content-Type' => $image->getMimeType()
        ]);
    }

    /**
     * Get the data for an image
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(string $id): JsonResponse
    {
        /** @var \Api\Models\Image $image */
        $image = Image::find($id);

        if ($image === null) {
            return $this->imageNotFound();
        }

        return $this->jsonSuccess($image->toArray() + [
            'url' => $image->getUrl(),
            'message' => Image::DETAILS
        ]);
    }

    /**
     * Create a list of images
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $limit = abs((int) $request->input('limit', 15));
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

        return $this->jsonSuccess([
            'images' => $images
        ]);
    }

    /**
     * Create a new image
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image']
        ]);

        if ($validator->passes()) {
            $imageFile = $request->file('image');
            $uuid = Uuid::generate(4)->string;

            $image = new Image;
            $image->id = $uuid;
            $image->slug = Image::generateSlug();
            $image->mime = $imageFile->getMimeType();

            Auth::user()->images()->save($image);
            $imageFile->move(storage_path('uploads/images'), $uuid);

            return $this->jsonSuccess($image->toArray() + [
                'url' => $image->getUrl(),
                'message' => Image::ADD_SUCCESS
            ]);
        } else {
            return $this->jsonError([
                'message' => Image::ADD_FAILED
            ]);
        }
    }

    /**
     * Remove an image
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, string $id): JsonResponse
    {
        /** @var \Api\Models\Image $image */
        $image = Image::find($id);

        if ($image === null) {
            return $this->imageNotFound();
        }

        if ($image->getUserId() === Auth::id()) {
            $image->delete();

            return $this->jsonSuccess([
                'message' => Image::DELETE_SUCCESS,
            ]);
        }

        return $this->jsonError([
            'message' => Image::DELETE_FAILED
        ]);
    }

    /**
     * Image not found response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function imageNotFound(): JsonResponse
    {
        return $this->jsonError([
            'message' => Image::NOT_FOUND
        ], Response::HTTP_NOT_FOUND);
    }
}
