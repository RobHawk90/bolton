<?php

namespace Bolton\Rest\Api;

use GuzzleHttp\Client;

class ArquiveiApi
{
    private $client;
    private $headers;

    public function __construct() {
        $this->client = new Client();

        $this->headers = [
            'content-type' => 'application/json',
            'x-api-id' => config('arquivei.api.id'),
            'x-api-key' => config('arquivei.api.key'),
        ];
    }

    public function nfeReceived($page = false)
    {
        $response = $this->client->request(
            'GET',
            $page ?: $this->getUrl('/v1/nfe/received'),
            ['headers' => $this->headers]
        );

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody());
        }

        return null;
    }

    public function getUrl($resource)
    {
        return config('arquivei.api.base_uri') . $resource;
    }
}
