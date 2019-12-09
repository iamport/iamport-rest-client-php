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
        $certification     = Certification::view(self::$impUid);

        $this->assertEquals('/certifications/' . self::$impUid, $certification->path());
        $this->assertEquals('GET', $certification->verb());
        $this->assertEmpty($certification->attributes());

        $response    = $this->iamport->callApi($certification);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }

    /** @test */
    public function delete_certification()
    {
        $certification     = Certification::delete(self::$impUid);

        $this->assertEquals('/certifications/' . self::$impUid, $certification->path());
        $this->assertEquals('DELETE', $certification->verb());
        $this->assertEmpty($certification->attributes());

        $response    = $this->iamport->callApi($certification);

        $this->assertInstanceOf('Iamport\RestClient\Result', $response);
    }
}
