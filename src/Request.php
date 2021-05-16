<?php


namespace Dotlines\Core;

use Dotlines\Core\Helpers\RequestHelper;
use Dotlines\Core\Interfaces\IRequest;

abstract class Request implements IRequest
{
    protected $requestMethod;
    protected $url;
    protected $accessToken = '';

    abstract public function params(): array;

    final public function headers(): array
    {
        return RequestHelper::make_headers($this->accessToken);
    }

    /**
     * @return array
     */
    final public function send(): array
    {
        return RequestHelper::send_request($this->requestMethod ?? 'POST', $this->url, $this->headers(), $this->params());
    }
}
