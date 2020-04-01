<?php

namespace Motwreen\Consumer\Services;

use Illuminate\Support\Facades\Http;

class HttpServices
{
    /* @var Http $http */
    public $client;

    /**
     * ApiConsumer constructor.
     * Init http with basic options
     */
    public function __construct()
    {
        $httpOptions = config('consumer.http');

        $http = Http::withOptions($httpOptions)->baseUrl(config('consumer.auth_server_url'));

        $this->client = $http;
    }

    /**
     * Set user access token
     *
     * @param $token
     *
     * @return $this
     */
    public function accessToken($token)
    {
        $this->client = $this->client->withToken($token);

        return $this->client;
    }
}
