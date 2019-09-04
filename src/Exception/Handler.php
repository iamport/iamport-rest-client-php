<?php

namespace Iamport\RestClient\Exception;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Iamport\RestClient\Result;

/**
 * Class Handler.
 */
class Handler
{
    /**
     * @param null $exception
     *
     * @throws IamportAuthException
     * @throws IamportRequestException
     * @throws Exception
     */
    public static function report($exception)
    {
        if ($exception instanceof IamportAuthException) {
            $message = $exception->getMessage();
            $code    = $exception->getCode();
            throw new IamportAuthException($message, $code);
        } elseif ($exception instanceof IamportRequestException) {
            throw new IamportRequestException($exception);
        } elseif ($exception instanceof ConnectException) {
            throw new Exception('[Connect Error] '.$exception->getMessage(), $exception->getCode());
        } elseif ($exception instanceof ServerException) {
            throw new Exception('[Server Error] '.$exception->getMessage(), $exception->getCode());
        } elseif ($exception instanceof ClientException) {
            $errorResponse = json_decode($exception->getResponse()->getBody());
            if (0 !== $errorResponse->code) {
                throw new IamportRequestException($errorResponse);
            }

            throw new Exception($errorResponse->message, $errorResponse->code);
        } else {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param Exception $exception
     *
     * @return Result
     */
    public static function render(Exception $exception)
    {
        return new Result(false, null, [
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]);
    }

    /**
     * @param $message
     * @param $code
     *
     * @return Result
     */
    public static function renderString($message, $code)
    {
        return new Result(false, null, [
            'code'    => $code,
            'message' => $message,
        ]);
    }
}
