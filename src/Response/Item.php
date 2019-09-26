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
     * @param $responseClass
     */
    public function __construct(array $response, $responseClass)
    {
        $this->response = $response;
        $this->clazz = $responseClass;
    }

    /**
     * @return mixed
     */
    public function getClassAs()
    {
        return new $this->clazz($this->response);
    }
}
