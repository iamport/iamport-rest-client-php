<?php

namespace Iamport\RestClient\Response;

/**
 * Class BenepiaPoint.
 */
class BenepiaPoint
{
    use ResponseTrait;

    /**
     * @var int
     */
    protected $point;

    /**
     * BenepiaPoint constructor.
     */
    public function __construct(array $response)
    {
        $this->point = $response['point'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPoint()
    {
        return $this->point;
    }
}
