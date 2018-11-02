<?php 
use PHPUnit\Framework\TestCase;

/**
*  Corresponding Class to test YourClass class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
class IamportRestClientTest extends TestCase
{
	
  const TEST_IMP_KEY = "imp_apikey";
  const TEST_IMP_SEC = "ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f";
  /**
  * Just check if the YourClass has no syntax error 
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
  public function testIsThereAnySyntaxError()
  {
    $iamportClient = new Iamport\RestClient\IamportRestClient(self::TEST_IMP_KEY, self::TEST_IMP_SEC);
    $this->assertTrue(is_object($iamportClient));
    unset($iamportClient);
  }
  
  /**
  * Just check if the YourClass has no syntax error 
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
  public function testRequestAccessToken()
  {
    $iamportClient = new Iamport\RestClient\IamportRestClient(self::TEST_IMP_KEY, self::TEST_IMP_SEC);
    $unauthorizedClient = new Iamport\RestClient\IamportRestClient(self::TEST_IMP_KEY, self::TEST_IMP_SEC . "garbage");

    try {
      $token = $iamportClient->requestAccessToken(true);
      $this->assertNotNull($token);
    } catch (Exception $e) {
      error_log($e->getMessage());
    }

    $this->expectException(IamportException::class);
    $token = $unauthorizedClient->requestAccessToken(true);
    
    unset($iamportClient);
    unset($unauthorizedClient);
  }

  public function testGetPaymentByImpUid()
  {
    $myImpUid = "imp_448280090638";
    $nonImpUid = "asdfasdfadsfads";

    $iamportClient = new Iamport\RestClient\IamportRestClient(self::TEST_IMP_KEY, self::TEST_IMP_SEC);

    try {
      $payment = $iamportClient->paymentByImpUid($myImpUid);
      $this->assertNotNull($payment);
    } catch (Exception $e) {
      error_log($e->getMessage());
    }

    $this->expectException(IamportException::class);
    $nonPayment = $iamportClient->paymentByImpUid($nonImpUid);
    
    unset($iamportClient);
  }
}
