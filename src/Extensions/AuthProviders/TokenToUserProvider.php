<?php

namespace Motwreen\Consumer\Extensions\AuthProviders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Motwreen\Consumer\Models\User;
use Motwreen\Consumer\Repositories\UserRepository;

class TokenToUserProvider implements UserProvider
{
    /* @var string $token */
    private $token;

    /* @var UserRepository $user */
    private $api;

    public function __construct($token)
    {
        $this->token = $token;
        $this->api = app(UserRepository::class);
    }

    public function retrieveById($identifier)
    {
        // retrieve user via id not necessary
    }

    /**
     * Get User By token
     *
     * @param mixed $identifier
     * @param string $token
     *
     * @return Authenticatable|User|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $user = $this->api->accessToken($token)->user();
        if (!$user)
            return null;

        $attributes = array_merge($user, [$identifier => $token]);
        $user = $this->fillUser($attributes);

        return $user ?? null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // update via remember token not necessary
    }

    /**
     * retrieve user by his credentials
     *
     * @param array $credentials
     *
     * @return Authenticatable|void|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        // retrieve by credentials not necessary
    }

    /**
     * Validate user credentials
     *
     * @param Authenticatable $user
     * @param array $credentials
     *
     * @return bool|void
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // validate credentials not necessary
    }

    /**
     * Set Fake User Model with data
     *
     * @param $attributes
     *
     * @return User
     */
    public function fillUser($attributes)
    {
        $user = new User();

        foreach ($attributes as $key => $value)
            $user->$key = $value;

        return $user;
    }
}
