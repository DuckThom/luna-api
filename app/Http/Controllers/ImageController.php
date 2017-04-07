<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Models\Image;

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
        /** @var \App\Models\Image $image */
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
     * Create a list of image
     */
    public function list(Request $request)
    {
        $limit = abs($request->input('limit', 15));
        $limit = ($limit < static::MAX_LIST_LIMIT ? $limit : static::MAX_LIST_LIMIT);
        $query = Image::limit($limit);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        $images = $query->get()->each(function ($image) {
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
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
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
     * @return JsonResponse
     */
    public function delete(Request $request, string $id)
    {
        $image = Image::find($id);

        if ($image === null) {
            return $this->imageNotFound();
        }

        if ($image->user_id === Auth::id()) {
            unlink($image->getPath());
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
     * @return JsonResponse
     */
    protected function imageNotFound()
    {
        return $this->jsonError([
            'message' => Image::NOT_FOUND
        ], Response::HTTP_NOT_FOUND);
    }
}
