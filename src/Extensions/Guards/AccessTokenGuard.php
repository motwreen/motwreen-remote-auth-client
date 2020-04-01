<?php

namespace Motwreen\Consumer\Extensions\Guards;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class AccessTokenGuard implements Guard
{
    use GuardHelpers;
    private $inputKey = '';
    private $storageKey = '';
    private $request;

    public function __construct(UserProvider $provider, Request $request, $configuration)
    {
        $this->provider = $provider;

        $this->request = $request;

        // key to check in request
//        $this->inputKey = isset($configuration['input_key']) ? $configuration['input_key'] : 'access_token';
        $this->inputKey = config('consumer.token_holder');

        // key to check in database
        $this->storageKey = isset($configuration['storage_key']) ? $configuration['storage_key'] : 'access_token';
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        //Get Token From Request
        $token = $this->getTokenForRequest();

        if (!empty($token)) {
            // the token was found, how you want to pass?
            $this->user = $this->provider->retrieveByToken($this->storageKey, $token);
        }
        return $this->user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string|null
     */
    public function getTokenForRequest()
    {
        //Get Token from query parameter
        $token = $this->request->query($this->inputKey);
        //Get Token from input
        if (empty($token)) {
            $token = $this->request->input($this->inputKey);
        }
        //Get Token from header access token
        if (empty($token)) {
            $token = $this->request->bearerToken();
        }
        //Get token from session
        if (empty($token)) {
            $token = session($this->inputKey);
        }
        //return token
        return $token ?? null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }

        $credentials = [$this->storageKey => $credentials[$this->inputKey]];

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * Check if user logged ing
     *
     * @return bool
     */
    public function check()
    {
        return (bool)$this->user();
    }

    /**
     * Check if user not logged-in
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }
}
