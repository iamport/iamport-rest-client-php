<?php

namespace Iamport\RestClient\Test;

use Iamport\RestClient\Request\Certification;
use PHPUnit\Framework\TestCase;

class CertificationTest extends TestCase
{
    use IamportTestTrait;

    /** @test */
    public function view_certification()
    {
        $request = Certification::view(self::$impUid);

        $this->assertEquals('/certifications/' . self::$impUid, $request->path());
        $this->assertEquals('GET', $request->verb());
        $this->assertEmpty($request->attributes());

        $response    = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function delete_certification()
    {
        $request     = Certification::delete(self::$impUid);

        $this->assertEquals('/certifications/' . self::$impUid, $request->path());
        $this->assertEquals('DELETE', $request->verb());
        $this->assertEmpty($request->attributes());

        $response    = $this->iamport->callApi($request);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
