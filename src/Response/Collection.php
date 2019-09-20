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
     * @param $response
     * @param string $responseType
     */
    public function __construct(array $response, string $responseType)
    {
        $this->total    = $response['total'];
        $this->previous = $response['previous'];
        $this->next     = $response['next'];

        $this->items = [];
        foreach ($response['list'] as $row) {
            $this->items[] = (new Item($row, $responseType))->getClassAs();
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
