<?php

namespace Iamport\RestClient\Exception;

use Exception;

/**
 * Class IamportAuthException.
 */
final class IamportAuthException extends Exception
{
    /**
     * IamportAuthException constructor.
     *
     * @param $message
     * @param $code
     */
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
