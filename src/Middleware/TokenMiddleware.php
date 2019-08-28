<?php

namespace Iamport\RestClient\Middleware;

use Psr\Http\Message\RequestInterface;

class TokenMiddleware
{
    private $token = null;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function __invoke(callable $handler)
    {
        return function (
            RequestInterface $request,
            array $options
    ) use ($handler) {
            $request = $request->withHeader('Authorization', 'Bearer '.$this->token);

            return $handler($request, $options);
        };
    }
}
