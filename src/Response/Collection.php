<?php

namespace Iamport\RestClient\Response;

/**
 * Class Collection.
 */
class Collection
{
    protected $total;
    protected $previous;
    protected $next;
    protected $items;

    /**
     * Collection constructor.
     *
     * @param array  $response
     * @param string $responseClass
     * @param bool   $isPaged
     */
    public function __construct(array $response, string $responseClass, bool $isPaged)
    {
        $this->items = [];
        $collection = $response;

        if ($isPaged) {
            $this->total    = $response['total'];
            $this->previous = $response['previous'];
            $this->next     = $response['next'];
            $collection = $response['list'];
        }



        foreach ($collection as $row) {
            $this->items[] = (new Item($row, $responseClass))->getClassAs();
        }
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @return int
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}
