<?php

namespace Iamport\RestClient\Response;

use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Response\Naver\NaverProductOrder;

/**
 * Class Collection.
 */
class Collection
{
    /**
     * @var RequestBase
     */
    protected $request;

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
     * @var array
     */
    protected $failed;

    /**
     * Collection constructor.
     *
     * @param array       $response
     * @param RequestBase $request
     * @param bool        $isMultiStatus
     */
    public function __construct(array $response, RequestBase $request, bool $isMultiStatus)
    {
        $this->items   = [];
        $this->request = $request;

        $responseClass = $this->request->responseClass;
        $isPaged       = $this->request->isPaged;

        if ($isPaged) {
            $collection     = $response['list'];
            $this->total    = $response['total'];
            $this->previous = $response['previous'];
            $this->next     = $response['next'];
        } else {
            $collection = $response;
            unset($this->total, $this->previous, $this->next, $this->request);
        }

        if ($isMultiStatus) {
            $diffColumn = 'imp_uid';
            if ($request->responseClass === Payment::class) {
                $diffColumn = 'imp_uid';
            } elseif ($request->responseClass === NaverProductOrder::class) {
                $diffColumn = 'product_order_id';
            }
            $imp_uid      = array_column($collection, $diffColumn);
            $this->failed = array_values(array_diff($request->imp_uids, $imp_uid));
        } else {
            unset($this->failed);
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

        if ($method === 'previous' && isset($this->previous)) {
            if ($this->getPrevious() === 0) {
                return null;
            }
            $this->request->page = $this->getPrevious();
        }

        if ($method === 'next' && isset($this->next)) {
            if ($this->getNext() === 0) {
                return null;
            }
            $this->request->page = $this->getNext();
        }

        return ($iamport->callApi($this->request))->getData();
    }
}
