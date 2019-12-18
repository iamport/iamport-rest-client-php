<?php

namespace Iamport\RestClient\Exception;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use Iamport\RestClient\Result;

/**
 * Class ExceptionHandler.
 */
final class ExceptionHandler
{
    public static function report($exception)
    {
        static $hasReport;

        if ($hasReport) {
            throw $exception;
        }
        if ($exception instanceof IamportException) {
            $hasIamportResponse = $exception->hasIamportResponse() ? $exception->getIamportResponse() : json_decode($exception->getResponse()->getBody());
            $hasReport          = true;
            throw new IamportException($hasIamportResponse, $exception->getRequest(), $exception->getResponse(), $exception, $exception->getHandlerContext());
        } elseif ($exception instanceof ConnectException) {
            //throw new Exception('RequestTrait Error(HTTP STATUS : '.$e->getcode().')', $e->getHandlerContext()['errno']);
            $hasReport = true;
            throw new ConnectException('[ConnectException] 연결에 실패했습니다. ' . $exception->getMessage(), $exception->getRequest(), $exception, $exception->getHandlerContext());
        } elseif ($exception instanceof TooManyRedirectsException) {
            $hasReport = true;
            throw new TooManyRedirectsException('[TooManyRedirectsException] 너무 많은 리디렉트 요청이 발생했습니다. ', $exception->getRequest(), $exception->getResponse(), $exception, $exception->getHandlerContext());
        } elseif ($exception instanceof ServerException) {
            $hasIamportResponse = json_decode($exception->getResponse()->getBody());
            $hasReport          = true;
            if ($hasIamportResponse) {
                throw new IamportException($hasIamportResponse, $exception->getRequest(), $exception->getResponse(), $exception, $exception->getHandlerContext());
            } else {
                throw new ServerException('[ServerException] API 서버 오류입니다 (5xx codes). ', $exception->getRequest(), $exception->getResponse(), $exception, $exception->getHandlerContext());
            }
        } elseif ($exception instanceof ClientException) {
            $hasIamportResponse = json_decode($exception->getResponse()->getBody());
            $hasReport          = true;
            if ($hasIamportResponse) {
                throw new IamportException($hasIamportResponse, $exception->getRequest(), $exception->getResponse(), $exception, $exception->getHandlerContext());
            } else {
                throw new ClientException('[ClientException] 클라이언트 오류입니다 (4xx codes). ', $exception->getRequest(), $exception->getResponse(), $exception, $exception->getHandlerContext());
            }
        }
    }

    public static function render($exception): Result
    {
        $error = new \stdClass();
        if ($exception instanceof IamportException) {
            if ($exception->hasIamportResponse()) {
                $error = (object) [
                    'code'     => $exception->getIamportResponse()->code,
                    'message'  => $exception->getIamportResponse()->message,
                    'previous' => $exception,
                ];

                $exception->deleteResponse();
            }
        } else {
            $error = (object) [
                'code'     => $exception->getCode(),
                'message'  => $exception->getMessage(),
                'previous' => $exception,
            ];
        }

        return new Result(null, $error);
    }
}
