<?php

/** @noinspection PhpUnusedPrivateMethodInspection */

namespace Dotlines\Core\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use JsonException;

class RequestHelper
{
    /**
     * @param string $HTTP_METHOD
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return mixed
     *
     * @throws JsonException
     * @noinspection PhpUndefinedConstantInspection
     */
    public static function send_request(string $HTTP_METHOD, string $url, array $headers = [], array $params = []): array
    {
        $response = (new Client())->sendAsync(new Request($HTTP_METHOD, $url, $headers, !empty($params) ? json_encode($params, JSON_THROW_ON_ERROR) : null))->wait();

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function make_headers(string $accessToken): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (!empty($accessToken)) {
            $headers['Authorization'] = 'Bearer '.$accessToken;
        }

        return $headers;
    }
}
