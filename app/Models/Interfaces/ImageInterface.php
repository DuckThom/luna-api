<?php

namespace App\Models\Interfaces;

/**
 * Image model interface
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
interface ImageInterface
{
    /**
     * Generate a unique slug.
     *
     * Throws an \Exception if the retry count exceeds SLUG_RETRY_LIMIT
     *
     * @return string
     * @throws \Exception
     */
    public static function generateSlug();

    /**
     * Get the url to the image.
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Add a view.
     *
     * @return int
     */
    public function addView(): int;

    /**
     * Get the image content.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Set the image content.
     *
     * @param  string  $content
     * @return $this
     */
    public function setContent(string $content);

    /**
     * Get the mime type.
     *
     * @return string
     */
    public function getMimeType(): string;

    /**
     * Set the image mime type.
     *
     * @param  string  $mime
     * @return $this
     */
    public function setMimeType(string $mime);

    /**
     * Get the user id.
     *
     * @return string
     */
    public function getUserId(): string;
}