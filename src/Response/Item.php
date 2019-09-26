<?php

namespace Iamport\RestClient\Response;

/**
 * Class Item.
 */
class Item
{
    /**
     *
     */
    private const NAMESPACE = 'Iamport\\RestClient\\Response\\';

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
     * @param array $response
     * @param string $responseType
     */
    public function __construct(array $response, string $responseType)
    {
        $this->response = $response;
        $this->clazz =  self::NAMESPACE . $responseType;
    }

    /**
     * @return mixed
     */
    public function getClassAs()
    {
        return new $this->clazz($this->response);
    }
}
