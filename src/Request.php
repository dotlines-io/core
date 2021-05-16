<?php


namespace Dotlines\Core;

use Dotlines\Core\Helpers\RequestHelper;
use Dotlines\Core\Interfaces\IRequest;
use Exception;
use JsonException;

abstract class Request implements IRequest
{
    protected string $requestMethod = 'POST';
    protected string $url = '';
    protected string $accessToken = '';

    abstract public function params(): array;

    final public function headers(): array
    {
        return RequestHelper::make_headers($this->accessToken);
    }

    /**
     * @return array
     * @throws JsonException
     * @throws Exception
     */
    final public function send(): array
    {
        return RequestHelper::send_request($this->requestMethod, $this->url, $this->headers(), $this->params());
    }
}
