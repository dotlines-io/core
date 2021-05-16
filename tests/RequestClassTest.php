<?php

/** @noinspection MethodVisibilityInspection */

namespace Dotlines\Core\Tests;

use Dotlines\Core\Request;
use Exception;
use JsonException;
use PHPUnit\Framework\TestCase;

class RequestClassTest extends TestCase
{
    /** @test
     */
    final public function it_can_prepare_mandatory_headers(): void
    {
        $requestObj = new class extends Request {
            final public function params(): array
            {
                return [];
            }
        };

        $headers = $requestObj->headers();

        self::assertArrayHasKey('Accept', $headers, "Accept header not exists in ");
        self::assertArrayHasKey('Content-Type', $headers);
    }

    /** @test
     */
    final public function it_can_prepare_mandatory_headers_with_access_token(): void
    {
        $requestObj = new class extends Request {
            public function __construct()
            {
                $this->accessToken = 'test';
            }

            final public function params(): array
            {
                return [];
            }
        };

        $headers = $requestObj->headers();
        self::assertArrayHasKey('Authorization', $headers);
    }

    /** @test
     * @throws JsonException
     */
    final public function it_gets_exception_if_url_missing(): void
    {
        $requestObj = new class extends Request {
            final public function params(): array
            {
                return [];
            }
        };

        $this->expectException(Exception::class);
        $requestObj->send();
    }

    /** @test
     * @throws JsonException
     */
    final public function it_can_send_get_request(): void
    {
        $requestObj = new class extends Request {
            public function __construct()
            {
                $this->requestMethod = 'GET';
                $this->url = 'https://sb-payments.ghoori.com.bd/api/normal/get/time';
            }

            final public function params(): array
            {
                return [];
            }
        };

        self::assertNotEmpty($requestObj->send());
    }

    /** @test
     * @throws JsonException
     */
    final public function it_can_send_get_request_with_params(): void
    {
        $requestObj = new class extends Request {
            public function __construct()
            {
                $this->requestMethod = 'GET';
                $this->url = 'https://sb-payments.ghoori.com.bd/api/normal/get/time?key1=val1&key2=val2';
            }

            final public function params(): array
            {
                return [];
            }
        };

        $response = $requestObj->send();

        self::assertNotEmpty($response);
        self::assertNotEmpty($response['params']);
    }

    /** @test
     * @throws JsonException
     */
    final public function it_can_send_post_request(): void
    {
        $requestObj = new class extends Request {
            public function __construct()
            {
                $this->requestMethod = 'POST';
                $this->url = 'https://sb-payments.ghoori.com.bd/api/normal/post/time';
            }

            final public function params(): array
            {
                return [];
            }
        };

        self::assertNotEmpty($requestObj->send());
    }

    /** @test
     * @throws JsonException
     */
    final public function it_can_send_post_request_with_params(): void
    {
        $requestObj = new class extends Request {
            public function __construct()
            {
                $this->requestMethod = 'POST';
                $this->url = 'https://sb-payments.ghoori.com.bd/api/normal/post/time';
            }

            final public function params(): array
            {
                return [
                    'key1' => 'val1',
                    'key2' => 'val2',
                ];
            }
        };

        $response = $requestObj->send();

        self::assertNotEmpty($response);
        self::assertNotEmpty($response['params']);
    }
}
