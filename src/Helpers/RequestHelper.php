<?php

namespace Dotlines\Core\Helpers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use JsonException;

class RequestHelper
{
    /**
     * @param string $HTTP_METHOD
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return array
     * @noinspection PhpUndefinedConstantInspection
     * @throws JsonException
     * @throws Exception
     * @throws GuzzleException
     */
    public static function send_request(string $HTTP_METHOD, string $url, array $headers = [], array $params = []): array
    {
        if (empty($url)) {
            throw new Exception("Request URL cannot be empty");
        }

        $response = (new Client())->send(new Request($HTTP_METHOD, $url, $headers, ! empty($params) ? json_encode($params, JSON_THROW_ON_ERROR) : null));

        return (array)json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function make_headers(string $accessToken): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (! empty($accessToken)) {
            $headers['Authorization'] = 'Bearer '.$accessToken;
        }

        return $headers;
    }

    /**
     * @param string $HTTP_METHOD
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return array
     * @noinspection PhpUndefinedConstantInspection
     * @throws JsonException
     * @throws Exception
     * @throws GuzzleException
     */
    public static function send_form_params_request(string $HTTP_METHOD, string $url, array $headers = [], array $params = []): array
    {
        if (empty($url)) {
            throw new Exception("Request URL cannot be empty");
        }

        $response = (new Client())->send(new Request($HTTP_METHOD, $url, $headers, http_build_query($params)));

        return (array)json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function make_form_params_headers(string $accessToken): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        if (! empty($accessToken)) {
            $headers['Authorization'] = 'Bearer '.$accessToken;
        }

        return $headers;
    }
}
