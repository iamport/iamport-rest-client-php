<?php

require_once '../../vendor/autoload.php';

use Iamport\RestClient\Iamport;

$iamport = new Iamport('imp_apikey', 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f');

try {
    $accessToken = $iamport->requestAccessToken();
} catch (Exception $e) {
    // 예외 처리
}
