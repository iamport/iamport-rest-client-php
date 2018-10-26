<?php 
namespace Iamport\RestClient\Response;

class IamportResponse
{

  private $internalResponse = null;
  private $resultCode = -1;
  private $resultMessage = null;
  private $resultBody = null;

  public function __construct($httpResponse)
  {
    $this->internalResponse = $httpResponse;
    $res = json_decode($httpResponse->getBody());

    if ($res) {
      $this->resultCode = $res->code;
      $this->resultMessage = $res->message;
      $this->resultBody = $res->response;
    }
  }

  public function isValid()
  {
    $statusCode = $this->internalResponse->getStatusCode();
    return $statusCode >= 200 && $statusCode < 300 && $this->resultCode === 0;
  }

  public function getMessage()
  {
    return $this->resultMessage;
  }

  public function getResponseAs($clazz)
  {
    return new $clazz($this->resultBody);
  }

  public function getHttpResponse()
  {
    return $this->internalResponse;
  }

}