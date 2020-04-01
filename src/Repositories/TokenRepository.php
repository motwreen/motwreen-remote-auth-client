<?php

namespace Motwreen\Consumer\Repositories;

use Motwreen\Consumer\Services\HttpServices;

class TokenRepository
{
    /* @var HttpServices $httpService */
    protected $httpService;

    protected $config = [];

    public function __construct()
    {
        $this->httpService = app(HttpServices::class);

        $this->config = [
            'client_id' => config('consumer.auth_server_client_id'),
            'client_secret' => config('consumer.auth_server_client_secret'),
            'redirect_uri' => config('consumer.auth_server_callback_url'),
        ];
    }

    /**
     * Exchange Authorization Code For Access Token
     *
     * @param string $code
     *
     * @return array|\Illuminate\Http\Client\Response
     */
    public function exchangeAuthorizationCodeForToken(string $code)
    {
        $data = array_merge($this->config, [
            'grant_type' => 'authorization_code',
            'code' => $code,
        ]);
        $endpoint = $this->endpoint('token');

        $request = $this->httpService->client->post($endpoint, $data);

        $response = $request->json();
//
        return $response;
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
        $prefix = trim(config('consumer.auth_server_oauth_path'), '/');
        $endpoint = trim($endpoint, '/');

        return $prefix . '/' . $endpoint;
    }


}
