<?php

namespace Iamport\RestClient\Response;

use GuzzleHttp\Psr7\Request;
use Iamport\RestClient\Exception\IamportException;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Response\Naver\NaverProductOrder;

/**
 * Class Collection.
 *
 * @method next
 * @method previous
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
            $this->setFailed($request, $collection);
        } else {
            unset($this->failed);
        }

        if (is_null($collection) || empty($collection)) {
            $iamportResponse = [
                'code'    => 404,
                'message' => '검색된 데이터가 없습니다.',
            ];
            throw new IamportException((object) $iamportResponse, new Request($request->verb(), $request->path()));
        } else {
            foreach ($collection as $item) {
                $this->items[] = (new Item($item, $responseClass))->getClassAs();
            }
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
     * @return array
     */
    public function getFailed()
    {
        return $this->failed;
    }

    public function setFailed(RequestBase $request, array $collection): void
    {
        $diffColumn    = 'imp_uid';
        $originKeyName = '';
        if ($request->responseClass === Payment::class) {
            $diffColumn    = 'imp_uid';
            $originKeyName = $diffColumn . 's';
        } elseif ($request->responseClass === SubscribeCustomer::class) {
            $diffColumn    = 'customer_uid';
            $originKeyName = $diffColumn . 's';
        } elseif ($request->responseClass === NaverProductOrder::class) {
            $originKeyName = $diffColumn = 'product_order_id';
        }

        $diffArray      = array_column($collection, $diffColumn);
        $this->failed   = array_values(array_diff($request->{$originKeyName}, $diffArray));
    }

    /**
     * @param $method
     * @param $args
     *
     * @return Collection|null
     */
    public function __call($method, $args)
    {
        if (in_array($method, ['previous', 'next'])) {
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
}
