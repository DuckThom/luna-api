<?php

namespace Api\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Api\Models\Interfaces\UserInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * User model.
 *
 * @author  Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, UserInterface
{
    use Authenticatable, Authorizable;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * Related image models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the model ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Set the model ID.
     *
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->attributes['id'] = $id;

        return $this;
    }

    /**
     * Get the user access token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->attributes['token'];
    }

    /**
     * Set the user access token.
     *
     * @param  string  $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->attributes['token'] = $token;

        return $this;
    }

    /**
     * Get the user name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Set the user name.
     *
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->attributes['name'] = $name;

        return $this;
    }
}
