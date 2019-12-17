<?php

namespace Iamport\RestClient\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Class TokenMiddleware.
 */
class TokenMiddleware
{
    /**
     * @var null
     */
    private $token = null;

    /**
     * TokenMiddleware constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function (
            RequestInterface $request,
            array $options
        ) use ($handler) {
            $request = $request->withHeader('Authorization', 'Bearer ' . $this->token);

            return $handler($request, $options);
        };
    }
}
