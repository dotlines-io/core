<?php


namespace Dotlines\Core;

use Dotlines\Core\Helpers\RequestHelper;
use Dotlines\Core\Interfaces\IRequest;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

abstract class Request implements IRequest
{
    protected string $requestMethod = 'POST';
    protected string $url = '';
    protected string $accessToken = '';

    abstract public function params(): array;

    /**
     * @noinspection MethodShouldBeFinalInspection
     */
    public function headers(): array
    {
        return RequestHelper::make_headers($this->accessToken);
    }

    /**
     * @return array
     * @throws JsonException
     * @throws Exception|GuzzleException
     * @noinspection MethodShouldBeFinalInspection
     */
    public function send(): array
    {
        return RequestHelper::send_request($this->requestMethod, $this->url, $this->headers(), $this->params());
    }
}
