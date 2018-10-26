<?php 
namespace Iamport\RestClient\Response;

class Payment
{
  private $responseBody = null;

  public function __construct($responseBody)
  {
    $this->responseBody = $responseBody;
  }

  public function getData($name)
  {
    if (is_null($this->responseBody)) {
      return null;
    }

    if (!isset($this->responseBody->{$name})) {
      return null;
    }

    return $this->responseBody->{$name};
  }

  public function getCustomData($name)
  {
    $data = $this->getData("custom_data");
    if (!isset($data->{$name})) {
      return null;
    }

    return $data->{$name};
  }

}