<?php 
namespace Iamport\RestClient;

use Iamport\RestClient\Middleware\TokenMiddleware;
use Iamport\RestClient\Middleware\DefaultRequestMiddleware;
use Iamport\RestClient\Response\IamportResponse;
use Iamport\RestClient\Response\Payment;
use Iamport\RestClient\Response\Auth;
use Iamport\RestClient\Exception\IamportException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\RequestException;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author yourname
*/
class IamportRestClient
{

  const API_BASE_URL = "https://api.iamport.kr";
  const EXPIRE_BUFFER = 30;

  /**  @var string $impKey define here what this variable is for, do this for every instance variable */
  private $impKey = null;
  private $impSecret = null;
  private $accessToken = null;
  private $expireTimestamp = 0;
 
  public function __construct($impKey, $impSecret)
  {
    $this->impKey = $impKey;
    $this->impSecret = $impSecret;
  }

  public function getAccessToken()
  {
    return $this->accessToken;
  }

  public function isTokenExpired()
  {
    $now = time();

    return $this->accessToken == null || ($this->expireTimestamp - self::EXPIRE_BUFFER) < $now;
  }

  /**
  * Sample method 
  *
  * Always create a corresponding docblock for each method, describing what it is for,
  * this helps the phpdocumentator to properly generator the documentation
  *
  * @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
  *
  * @return string
  */
  public function paymentByImpUid($impUid)
  {
    $httpClient = $this->getHttpClient(true);

    $paymentUrl = self::API_BASE_URL . "/payments/" . $impUid;
    $response = new IamportResponse($httpClient->get($paymentUrl));

    if (!$response->isValid()) {
      throw new IamportException($response);
    }

    return $response->getResponseAs(Payment::class);
  }

  public function requestAccessToken($force)
  {
    if (!$this->isTokenExpired() && !$force) {
      return $this->accessToken;
    }

    $httpClient = $this->getHttpClient(false);

    $authUrl = self::API_BASE_URL . "/users/getToken";
    $response = new IamportResponse($httpClient->post($authUrl, [
      RequestOptions::JSON => [
        "imp_key" => $this->impKey,
        "imp_secret" => $this->impSecret,
      ]
    ]));

    if (!$response->isValid()) {
      throw new IamportException($response);
    }

    $auth = $response->getResponseAs(Auth::class);

    $this->accessToken = $auth->getAccessToken();
    //호출하는 서버의 시간이 동기화되어있지 않을 가능성 고려 ( 로컬 서버 타임기준 계산 )
    $this->expireTimestamp = time() + $auth->getRemaindSeconds();

    return $this->accessToken;
  }

  private function getHttpClient($authenticated)
  {
    $stack = HandlerStack::create();
    $stack->push(new DefaultRequestMiddleware());

    if ($authenticated) {
      $token = $this->requestAccessToken(false);
      $stack->push(new TokenMiddleware($token));
    }
    
    $client = new Client(["handler" => $stack]);

    return $client;
  }

}