<?php

namespace Api\Models\Interfaces;

/**
 * User model interface.
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
interface UserInterface
{
    /**
     * Get the user id.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set the user id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id);

    /**
     * Get the access token.
     *
     * @return string
     */
    public function getToken(): string;

    /**
     * Set the access token.
     *
     * @param  string  $token
     * @return $this
     */
    public function setToken(string $token);

    /**
     * Get the user name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the user name.
     *
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name);
}
