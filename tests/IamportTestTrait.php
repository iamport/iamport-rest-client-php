<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Iamport;

/**
 * Trait IamportTestTrait.
 *
 * @property Iamport $iamport
 */
trait IamportTestTrait
{
    /**
     * @var string
     */
    public static $testImpKey = 'imp_apikey';
    /**
     * @var string
     */
    public static $testImpSec = 'ekKoeW8RyKuT0zgaZsUtXXTLQ4AhPFW3ZGseDA6bkA5lamv9OqDMnxyeB9wqOsuO9W3Mx9YSJ4dTqJ3f';

    /**
     * @var string
     */
    public static $impUid      = 'imp_448280090638';
    /**
     * @var string
     */
    public static $merchantUid = 'merchant_1448280088556';
    /**
     * @var string
     */
    public static $customerUid = 'customer_1234';

    /**
     * @var
     */
    protected $iamport;

    /**
     * This method is called before each test.
     */
    protected function setUp()
    {
        $this->iamport = new Iamport(self::$testImpKey, self::$testImpSec);
    }

    protected function tearDown()
    {
        $this->iamport  = null;
    }
}
