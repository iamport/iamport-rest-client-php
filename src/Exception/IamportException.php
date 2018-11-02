<?php 
namespace Iamport\RestClient\Exception;

class IamportException extends Exception
{

  private $iamportResponse;

  public function __construct($response)
  {
    parent::__construct($response->getMessage(), $response->getCode());

    $this->iamportResponse = $response;
  }

  public function getIamportResponse()
  {
    return $this->iamportResponse;
  }

}