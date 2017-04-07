<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\WordsGenerator;

class Image extends Model
{
    const NOT_FOUND = 'No image was found with the given tag';
    const DETAILS = 'Image details';
    const ADD_FAILED = 'A error occurred while saving the image';
    const ADD_SUCCESS = 'The image has been uploaded successfully';
    const DELETE_FAILED = 'An error occurred while deleting the image';
    const DELETE_SUCCESS = 'The image has been deleted';
    const SLUG_RETRY_LIMIT = 3;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $hidden = ['user_id', 'content'];

    /**
     * The owner of the image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique slug
     *
     * Throws an \Exception if the retry count exceeds SLUG_RETRY_LIMIT
     *
     * @return string
     * @throws \Exception
     */
    public static function generateSlug()
    {
        $exists = true;
        $loops = 0;

        while ($exists) {
            if ($loops > static::SLUG_RETRY_LIMIT) {
                throw new \Exception('Could not find an available slug.');
            }

            $slug = WordsGenerator::make();
            $exists = (bool) static::where('slug', $slug)->count();
            $loops++;
        }

        return $slug;
    }

    /**
     * Get the url to the image
     *
     * @return string
     */
    public function getUrl()
    {
        return route('image.show', ['slug' => $this->attributes['slug']]);
    }

    /**
     * Add a view
     *
     * @return int
     */
    public function addView()
    {
        $this->attributes['views']++;
        $this->save();

        return $this->attributes['views'];
    }

    /**
     * Get the image content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->attributes['content'];
    }

    /**
     * Get the mime type
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->attributes['mime'];
    }
}
