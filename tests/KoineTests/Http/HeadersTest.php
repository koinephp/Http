<?php

namespace KoineTess;

use Koine\Http\Headers;
use Koine\Http\Header;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class HeadersTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Headers();
    }

    /**
     * @test
     */
    public function extendsHash()
    {
        $this->assertInstanceOf('Koine\Hash', $this->object);
    }

    /**
     * @test
     */
    public function isInitiallyNotSent()
    {
        $this->assertFalse($this->object->sent());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function sendSendsHeader()
    {
        $this->object['Location'] = '/';
        $this->assertTrue($this->object->send()->sent());

        // Won't return the correct headers
        // $this->assertEquals(array('Location: /'), headers_list());
    }

    /**
     * @test
     * @expectedException Koine\Http\Exceptions\HeadersAlreadySentException
     * @expectedExceptionMessage Headers already sent
     */
    public function sendThrowsAnExceptionWhenHeadersHaveAlreadyBeenSent()
    {
        $this->object->send();
        $this->object->send();
    }

    /**
     * @test
     */
    public function setLocationSetsTheHeaderLocation()
    {
        $headers = $this->object->setLocation('/');

        $this->assertEquals('Location: /', (string) $headers->first());
    }

    /**
     * @test
     */
    public function setContentTypeSetsTheContentType()
    {
        $headers = $this->object->setContentType('application/json');

        $expected = 'Content-Type: application/json';

        $this->assertEquals($expected, (string) $headers->first());
    }

    /**
     * @test
     */
    public function canClearHeaders()
    {
        $headers = $this->object
            ->setContentType('application/json')
            ->clear()
            ->toArray();

        $this->assertEquals(array(), $headers);
    }

    /**
     * @test
     */
    public function setAndGetHeader()
    {
        $header = new Header('Content-Type', "application/json");
        $this->object['Content-Type'] = $header;

        $this->assertSame($header, $this->object['Content-Type']);
    }
}
