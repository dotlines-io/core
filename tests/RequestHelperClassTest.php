<?php

/** @noinspection MethodVisibilityInspection */

namespace Dotlines\Core\Tests;

use Dotlines\Core\Helpers\RequestHelper;
use Exception;
use JsonException;
use PHPUnit\Framework\TestCase;

class RequestHelperClassTest extends TestCase
{
    protected $backupStaticAttributes = false;
    protected $runTestInSeparateProcess = false;

    /**
     * @test
     */
    final public function it_can_prepare_mandatory_headers(): void
    {
        $headers = RequestHelper::make_headers('');

        self::assertArrayHasKey('Accept', $headers, "Accept header not exists in ");
        self::assertArrayHasKey('Content-Type', $headers);
    }

    /**
     * @test
     */
    final public function it_can_prepare_mandatory_headers_with_access_token(): void
    {
        $headers = RequestHelper::make_headers('test');
        self::assertArrayHasKey('Authorization', $headers);
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_if_url_missing(): void
    {
        $headers = RequestHelper::make_headers('');
        $this->expectException(Exception::class);
        RequestHelper::send_request("POST", "", $headers, []);
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_can_send_get_request(): void
    {
        $headers = RequestHelper::make_headers('');
        self::assertNotEmpty(RequestHelper::send_request('GET', 'https://sb-payments.ghoori.com.bd/api/normal/get/time', $headers, []));
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_can_send_get_request_with_params(): void
    {
        $headers = RequestHelper::make_headers('');

        $response = RequestHelper::send_request('GET', 'https://sb-payments.ghoori.com.bd/api/normal/get/time?key1=val1&key2=val2', $headers, []);

        self::assertNotEmpty($response);
        self::assertNotEmpty($response['params']);
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_can_send_post_request(): void
    {
        $headers = RequestHelper::make_headers('');
        self::assertNotEmpty(RequestHelper::send_request('POST', 'https://sb-payments.ghoori.com.bd/api/normal/post/time', $headers, []));
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_can_send_post_request_with_params(): void
    {
        $headers = RequestHelper::make_headers('');

        $response = RequestHelper::send_request('POST', 'https://sb-payments.ghoori.com.bd/api/normal/post/time', $headers, [ 'key1' => 'val1', 'key2' => 'val2', ]);

        self::assertNotEmpty($response);
        self::assertNotEmpty($response['params']);
    }
}
