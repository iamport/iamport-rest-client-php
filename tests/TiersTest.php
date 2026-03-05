<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Tiers;
use PHPUnit\Framework\TestCase;

class TiersTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function tiers_view()
    {
        $request = Tiers::view('ABC');

        $this->assertEquals('/tiers/ABC', $request->path());
        $this->assertEquals('GET', $request->verb());
        $this->assertEmpty($request->attributes());

        $response = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
