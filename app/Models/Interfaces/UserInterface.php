<?php

namespace App\Models\Interfaces;

/**
 * User model interface
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
interface UserInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id);

    /**
     * @return string
     */
    public function getToken(): string;

    /**
     * @param  string  $token
     * @return $this
     */
    public function setToken(string $token);
}