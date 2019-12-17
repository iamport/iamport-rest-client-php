<?php

namespace Iamport\RestClient\Response;

/**
 * Class Item.
 */
class Item
{
    /**
     * @var array
     */
    private $response;

    /**
     * @var string
     */
    private $clazz;

    /**
     * Item constructor.
     *
     * @param $responseClass
     */
    public function __construct(array $response, $responseClass)
    {
        date_default_timezone_set('Asia/Seoul');
        $this->response = $response;
        $this->clazz    = $responseClass;
    }

    /**
     * @return mixed
     */
    public function getClassAs()
    {
        return new $this->clazz($this->response);
    }
}
