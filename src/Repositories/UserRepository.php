<?php

namespace Motwreen\Consumer\Repositories;

use Motwreen\Consumer\Services\HttpServices;

class UserRepository
{
    /* @var HttpServices $httpService */
    protected $httpService;

    public function __construct()
    {
        $this->httpService = app(HttpServices::class);
    }

    /**
     * Set access token for user
     *
     * @param $token
     *
     * @return $this
     */
    public function accessToken($token)
    {
        $this->httpService->accessToken($token);

        return $this;
    }

    /**
     * Format endpoint before request
     *
     * @param string $endpoint
     *
     * @return string
     */
    protected function endpoint(string $endpoint): string
    {
        $prefix = trim(config('consumer.auth_server_api_prefix'), '/');
        $endpoint = trim($endpoint, '/');

        return $prefix . '/' . $endpoint;
    }

    /**
     * Get user from token service
     *
     * @return array|\Illuminate\Http\Client\Response
     */
    public function user()
    {
        $endpoint = $this->endpoint(config('consumer.auth_server_user_data_path'));
        $request = $this->httpService->client->post($endpoint);
        //in case of error return null
        if($request->serverError() || $request->clientError())
            return null;

        // return user
        $response = $request->json();

        return $response;
    }

    /**
     * Update logged-in user data
     *
     * @param $data
     *
     * @return array|\Illuminate\Http\Client\Response
     */
    public function update($data)
    {
        $endpoint = $this->endpoint(config('consumer.auth_server_user_data_path'));
        $request = $this->httpService->client->post($endpoint, $data);
        //in case of error return false
        if($request->serverError() || $request->clientError())
            return false;

        $response = $request->json();

        return $response;
    }


}
