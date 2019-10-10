<?php

namespace Iamport\RestClient\Response;

/**
 * Class Collection.
 */
class Collection
{
    /**
     * @var mixed
     */
    protected $total;

    /**
     * @var mixed
     */
    protected $previous;

    /**
     * @var mixed
     */
    protected $next;

    /**
     * @var array
     */
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
        $this->items   = [];

        if ($isPaged) {
            $collection     = $response['list'];
            $this->total    = $response['total'];
            $this->previous = $response['previous'];
            $this->next     = $response['next'];
        } else {
            $collection = $response;
            unset($this->total);
            unset($this->previous);
            unset($this->next);
        }

        foreach ($collection as $item) {
            $this->items[] = (new Item($item, $responseClass))->getClassAs();
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

    /**
     * @param $method
     * @param $args
     *
     * @return Collection|null
     */
    public function __call($method, $args)
    {
        $iamport = $args[0];
        $request = $args[1];

        if ($method === 'previous' && isset($this->previous)) {
            if ($this->getPrevious() === 0) {
                return null;
            }
            $request->page = $this->getPrevious();
        }

        if ($method === 'next' && isset($this->next)) {
            if ($this->getNext() === 0) {
                return null;
            }
            $request->page = $this->getNext();
        }

        return ($iamport->callApi($request))->getData();
    }
}
